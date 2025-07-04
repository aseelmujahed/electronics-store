<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class UserCart extends Component
{
    public $showCheckout = false;

    protected function getTenantId()
    {
        return tenant('id');
    }

    public function removeFromCart($cartId)
    {
        $item = Cart::where('id', $cartId)
            ->where('tenant_id', $this->getTenantId())
            ->where('user_id', Auth::id())
            ->first();
        if ($item) {
            $item->delete();
        }
    }

    public function increaseQuantity($cartId)
    {
        $item = Cart::where('id', $cartId)
            ->where('tenant_id', $this->getTenantId())
            ->where('user_id', Auth::id())
            ->first();
        if ($item) {
            $item->quantity += 1;
            $item->save();
        }
    }

    public function decreaseQuantity($cartId)
    {
        $item = Cart::where('id', $cartId)
            ->where('tenant_id', $this->getTenantId())
            ->where('user_id', Auth::id())
            ->first();
        if ($item) {
            if ($item->quantity > 1) {
                $item->quantity -= 1;
                $item->save();
            } else {
                $item->delete();
            }
        }
    }

    public function checkout()
    {
        $cartCount = Cart::where('user_id', Auth::id())
            ->where('tenant_id', $this->getTenantId())
            ->count();
        if ($cartCount == 0) {
            session()->flash('error', 'Your cart is empty!');
            return;
        }
        $this->showCheckout = true;
    }

    public function placeOrder()
    {
        $userId = Auth::id();
        $tenantId = $this->getTenantId();

        $cartItems = Cart::with('product')
            ->where('user_id', $userId)
            ->where('tenant_id', $tenantId)
            ->get();

        if ($cartItems->count() == 0) {
            session()->flash('error', 'Your cart is empty!');
            $this->showCheckout = false;
            return;
        }

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $order = Order::create([
            'user_id' => $userId,
            'tenant_id' => $tenantId,
            'total' => $total,
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'tenant_id' => $tenantId,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
            $item->delete();
        }

        $this->showCheckout = false;
        session()->flash('message', 'Your order has been placed successfully!');
    }

    public function render()
    {
        $cartItems = [];
        $total = 0;
        $tenantId = $this->getTenantId();

        if (Auth::check()) {
            $cartItems = Cart::with('product')
                ->where('user_id', Auth::id())
                ->where('tenant_id', $tenantId)
                ->get();

            $total = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });
        }

        return view('livewire.user-cart', [
            'cartItems' => $cartItems,
            'total' => $total,
        ])->layout('layouts.app');
    }
}
