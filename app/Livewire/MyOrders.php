<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class MyOrders extends Component
{

    public function cancelOrder($orderId)
    {
        $order = \App\Models\Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->where('delivery_status', 'pending')
            ->first();

        if ($order) {
            $order->delivery_status = 'cancelled';
            $order->save();
            session()->flash('message', __('messages.order_cancelled_successfully'));
        } else {
            session()->flash('error', __('messages.cannot_cancel_order'));
        }
    }

    public function render()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'asc')
            ->get();

        return view('livewire.my-orders', [
            'orders' => $orders,
        ])->layout('layouts.app');
    }
}
