<div class="max-w-2xl mx-auto py-10 px-2 sm:px-4">
    <h2 class="text-2xl font-bold mb-8">Your Cart</h2>
    @if(count($cartItems) === 0)
    <p>Your cart is empty.</p>
    @else
    <div class="space-y-4 mb-4">
        @foreach($cartItems as $item)
        <div class="flex flex-row items-center justify-between bg-white shadow rounded p-4 gap-4 overflow-x-auto">

            <img src="{{ $item->product->image ?? 'https://via.placeholder.com/50' }}"
                alt="{{ $item->product->name }}"
                class="w-16 h-16 object-cover rounded flex-shrink-0">

            <div class="flex flex-col justify-center flex-1 min-w-0">
                <div class="font-semibold break-words">{{ $item->product->name }}</div>
                <div class="flex items-center gap-2 mt-2">
                    <button wire:click="decreaseQuantity({{ $item->id }})"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 rounded px-2 text-lg leading-tight">-</button>
                    <span class="text-sm">{{ $item->quantity }}</span>
                    <button wire:click="increaseQuantity({{ $item->id }})"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 rounded px-2 text-lg leading-tight">+</button>
                </div>
            </div>

            <div class="flex flex-row items-center gap-4 flex-shrink-0">
                <span class="font-bold min-w-max">{{ $item->product->price * $item->quantity }} ₪</span>
                <button wire:click="removeFromCart({{ $item->id }})"
                    class="bg-red-600 hover:bg-red-700 text-white rounded px-3 py-1 text-sm">
                    Remove
                </button>
            </div>
        </div>

        @endforeach
    </div>
    <div class="font-bold text-lg text-right">
        Total: {{ $total }} ₪
    </div>
    @endif

    @if(count($cartItems) > 0)
    <div class="flex justify-end mt-6">
        <button
            wire:click="checkout"
            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow transition w-full sm:w-auto">
            Checkout
        </button>
    </div>
    @endif

    @if($showCheckout)
    <div class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center p-2">
        <div class="bg-white rounded-lg shadow-lg p-4 sm:p-8 max-w-lg w-full">
            <h3 class="text-2xl font-bold mb-4">Confirm your order</h3>
            <ul class="mb-4">
                @foreach($cartItems as $item)
                <li class="mb-2 flex justify-between">
                    <span>{{ $item->product->name }} <span class="text-xs text-gray-500">x{{ $item->quantity }}</span></span>
                    <span>{{ $item->product->price * $item->quantity }} ₪</span>
                </li>
                @endforeach
            </ul>
            <div class="font-bold mb-4">Total: {{ $total }} ₪</div>
            <div class="flex flex-col sm:flex-row gap-4">
                <button wire:click="placeOrder"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow w-full sm:w-auto">Confirm</button>
                <button wire:click="$set('showCheckout', false)"
                    class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded w-full sm:w-auto">Cancel</button>
            </div>
        </div>
    </div>
    @endif
</div>