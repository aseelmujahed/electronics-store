<div class="max-w-2xl mx-auto py-10 px-2 sm:px-4">
    @php
    $align = app()->getLocale() == 'ar' ? 'text-right' : 'text-left';

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

    @if (session()->has('message'))
    <div class="bg-green-100 text-green-700 p-2 mb-4 rounded {{ $align }}">
        {{ session('message') }}
    </div>
    @endif
    @if (session()->has('error'))
    <div class="bg-red-100 text-red-700 p-2 mb-4 rounded {{ $align }}">
        {{ session('error') }}
    </div>
    @endif

    <h2 class="text-3xl font-bold mb-8 text-center">{{ __('messages.my_orders') }}</h2>

<div class="bg-white rounded shadow p-6" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

        <div class="mb-4 flex items-center justify-center rounded bg-blue-50 px-3 py-2 text-blue-700 text-sm">
            <svg
                class="w-4 h-4 text-gray-400 flex-shrink-0"
                style="margin-inline-end: 0.5rem;"
                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" />
                <path d="M12 6v6l4 2" />
            </svg>
            {{ __('messages.cancel_note') }}
        </div>

    <div class="overflow-x-auto">
        <table class="w-full bg-white rounded shadow text-center">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b ">{{ __('messages.order_id') }}</th>
                        <th class="px-4 py-2 border-b ">{{ __('messages.total') }}</th>
                        <th class="px-5 py-2 border-b ">{{ __('messages.status') }}</th>
                        <th class="px-4.4 py-2 border-b ">{{ __('messages.date') }}</th>
                        <th class="px-4 py-2 border-b">{{ __('messages.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                    <tr class="hover:bg-blue-50 transition">
                        <td class="px-4 py-2 border-b text-gray-700 font-semibold">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border-b text-indigo-600 font-bold">{{ number_format($order->total, 1) }} ₪</td>
                        <td class="px-4 py-2 border-b">
                            <span class="inline-block px-5 py-1 rounded-full text-sm font-semibold {{ statusColor($order->delivery_status) }}">
                                {{ __('messages.status_' . $order->delivery_status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 border-b text-gray-500">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                        <td class="px-4 py-2 border-b">
                            @if($order->delivery_status == 'pending')
                            <button
                                wire:click="cancelOrder({{ $order->id }})"
                                class="bg-red-600 hover:bg-red-600 text-white px-3 py-1 rounded transition">
                                {{ __('messages.cancel_order') }}
                            </button>
                            @else
                            <span class="text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-gray-400 text-lg">
                            {{ __('messages.no_orders') }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>