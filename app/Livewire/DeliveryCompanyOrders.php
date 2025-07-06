<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Order;

class DeliveryCompanyOrders extends Component
{
    public $stores = [];
    public $selectedStoreId = null;
    public $orders = [];
    public $storeName = null;

    public function mount()
    {
        $this->stores = DB::table('tenants')->get(['id'])->toArray();
    }
    public $users = [];

    public function selectStore($tenantId)
    {
        $this->selectedStoreId = $tenantId;
        $this->storeName = $tenantId;

        $this->orders = Order::where('tenant_id', $tenantId)
            ->orderBy('created_at', 'Asc')
            ->get()
            ->toArray();

        $this->users = DB::table('users')->get(['id', 'name', 'location'])->keyBy('id')->toArray();

    }
    public function updateStatus($orderId, $status)
    {
        $order = Order::where('id', $orderId)
            ->where('tenant_id', $this->selectedStoreId)
            ->first();

        if ($order) {
            $order->delivery_status = $status;
            $order->save();

            $this->selectStore($this->selectedStoreId);

            session()->flash('message', __('messages.order_status_updated'));
        }
    }

    public function render()
    {
        return view('livewire.delivery-company-orders')->layout('layouts.app');
    }
}
