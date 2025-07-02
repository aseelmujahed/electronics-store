<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class ProductList extends Component
{
    public $search = '';
    public $searchInput = '';

    public function doSearch()
    {
        $this->search = $this->searchInput;
    }

    public function addToCart($productId) {
        if (!Auth::check()) {
            session()->flash('error', 'You must login first!');
            return;
        }

        $userId = Auth::id();

        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        $this->dispatch('toast', message: 'Product added to your cart!');

    }
    
    public function render()
    {
        return view('livewire.product-list', [
            'products' => \App\Models\Product::when($this->search, function ($query) {
                $search = $this->search;
                return $query->where('name', 'like', "%$search%");
            })->get(),
        ])->layout('layouts.app');
    }
}
