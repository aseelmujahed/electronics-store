<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductList extends Component
{
    public $search = '';
    public $searchInput = '';

    public function doSearch()
    {
        $this->search = $this->searchInput;
    }

    public function addToCart($productId)
    {
        Log::info("addToCart called", [
        'user_id' => Auth::id(),
        'tenant_id' => tenant('id'),
        'product_id' => $productId
    ]);
        if (!Auth::check()) {
            session()->flash('error', 'You must login first!');
            return;
        }

        $userId = Auth::id();

        $product = Product::where('id', $productId)
            ->where('tenant_id', tenant('id'))
            ->first();

        if (!$product) {
            session()->flash('error', 'This product does not belong to this store.');
            return;
        }

        $cartItem = Cart::where('user_id', $userId)
    ->where('product_id', $productId)
    ->where('tenant_id', tenant('id'))
    ->first();


        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => 1,
                'tenant_id' => tenant('id'),
            ]);
        }

        $this->dispatch('toast', message: 'Product added to your cart!');
    }

    public function render()
    {
        Log::info("RENDER PRODUCTLIST", [
        'tenant_id' => tenant('id'),
        'route' => request()->path()
    ]);
        $tenantId = tenant('id');

        return view('livewire.product-list', [
            'products' => Product::where('tenant_id', $tenantId)
                ->when($this->search, function ($query) {
                    $search = $this->search;
                    return $query->where('name', 'like', "%$search%");
                })->get(),
        ])->layout('layouts.app');
    }
}
