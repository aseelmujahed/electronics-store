<div class="max-w-2xl mx-auto py-12 px-2 sm:px-4">
        @php
    $isArabic = app()->getLocale() == 'ar';
    $align = $isArabic ? 'text-right' : 'text-left';
    $dir = $isArabic ? 'rtl' : 'ltr';

    function statusColor($status) {
    return [
    'pending' => 'bg-yellow-100 text-yellow-700',
    'processing' => 'bg-blue-100 text-blue-700',
    'shipped' => 'bg-purple-100 text-purple-700',
    'delivered' => 'bg-green-100 text-green-700',
    'cancelled' => 'bg-red-100 text-red-700',
    ][$status] ?? 'bg-gray-100 text-gray-700';
    }
    @endphp

    <h2 class="text-2xl font-bold mb-8 text-center">{{ __('messages.delivery_company_dashboard') }}</h2>

    @if(!$selectedStoreId)
    <div class="bg-white rounded shadow p-6">
        <h3 class="text-lg font-semibold mb-4 {{ $align }}">{{ __('messages.choose_store') }}</h3>
        <ul>
            @foreach($stores as $store)
            <li>
                <button
                    wire:click="selectStore('{{ $store->id }}')"
                    class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded shadow mb-3 last:mb-0">
                    {{ $store->id }}
                </button>
            </li>
            <br>
            @endforeach
        </ul>

    </div>
    @else
    <div class="bg-white rounded shadow p-6" dir="{{ $dir }}">
   <div class="mb-6 flex justify-start">
    <button
        wire:click="$set('selectedStoreId', null)"
        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 bg-gray-100 text-gray-800 font-semibold hover:bg-gray-200 hover:border-gray-400 transition"
    >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M15 19l-7-7 7-7" />
        </svg>
        {{ __('messages.back_to_stores') }}
    </button>
</div>


        <h3 class="text-lg font-bold flex-1 text-center">
            {{ __('messages.orders_for_store') }}:
            <span class="text-blue-700">{{ $storeName }}</span>
        </h3>
        <br>
        @if (session()->has('message'))
        <div class="bg-green-100 text-green-700 p-2 mb-4 rounded {{ $align }}">
            {{ session('message') }}
        </div>
        @endif
        <div class="overflow-x-auto">
          <table class="w-full bg-white rounded shadow text-center">
    <thead>
        <tr>
            <th class="px-2 py-2 border-b">{{ __('messages.order_id') }}</th>
            <th class="px-3 py-2 border-b">{{ __('messages.customer') }}</th>
            <th class="px-3 py-2 border-b">{{ __('messages.location') }}</th> 
            <th class="px-3 py-2 border-b">{{ __('messages.total') }}</th>
            <th class="px-3 py-2 border-b">{{ __('messages.status') }}</th>
            <th class="px-3 py-2 border-b">{{ __('messages.date') }}</th>
            <th class="px-3 py-2 border-b">{{ __('messages.action') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($orders as $i => $order)
        <tr class="hover:bg-blue-50 transition">
            <td class="px-2 py-2 border-b">{{ $order['id'] }}</td>
            <td class="px-3 py-2 border-b">{{ $users[$order['user_id']]->name ?? '-' }}</td>
            <td class="px-3 py-2 border-b">{{ $users[$order['user_id']]->location ?? '-' }}</td>
            <td class="px-3.3 py-2 border-b text-indigo-600 font-bold">{{ number_format($order['total'], 1) }} ₪</td>
                        <td class="px-3 py-2 border-b">
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ statusColor($order['delivery_status']) }}">
                                {{ __('messages.status_' . $order['delivery_status']) }}
                            </span>
                        </td>
                        <td class="px-3.6 py-2 border-b text-gray-500">
                            <span class="inline-flex items-center gap-1">
                                {{ \Carbon\Carbon::parse($order['created_at'])->format('Y-m-d') }}
                            </span>
                        </td>
                        <td class="px-3 py-2 border-b">
                            <select wire:change="updateStatus('{{ $order['id'] }}', $event.target.value)"
                                class="border rounded px-2 py-1 text-sm">
                                @foreach(['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                                <option value="{{ $status }}"
                                    @if($order['delivery_status']==$status) selected @endif>
                                    {{ __('messages.status_' . $status) }}
                                </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-gray-400 text-lg">
                            {{ __('messages.no_orders') }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>