<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;

class UserCart extends Component
{
    public $showCheckout = false;

    public function removeFromCart($cartId)
    {
        $item = Cart::find($cartId);
        if ($item && $item->user_id == Auth::id()) {
            $item->delete();
        }
    }

    public function increaseQuantity($cartId)
    {
        $item = Cart::find($cartId);
        if ($item && $item->user_id == Auth::id()) {
            $item->quantity += 1;
            $item->save();
        }
    }

    public function decreaseQuantity($cartId)
    {
        $item = Cart::find($cartId);
        if ($item && $item->user_id == Auth::id()) {
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
        if (Cart::where('user_id', Auth::id())->count() == 0) {
            session()->flash('error', 'Your cart is empty!');
            return;
        }
        $this->showCheckout = true;
    }
    public function placeOrder()
    {
        $userId = Auth::id();
        $cartItems = Cart::with('product')->where('user_id', $userId)->get();

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
            'total' => $total,
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
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

        if (Auth::check()) {
            $cartItems = Cart::with('product')
                ->where('user_id', Auth::id())
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
