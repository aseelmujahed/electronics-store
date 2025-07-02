<div class="max-w-7xl mx-auto py-6 px-2 sm:px-4 lg:px-8">

    <h2 class="text-3xl font-bold mb-8 text-center">All Products</h2>

    <div class="flex items-center justify-center mb-8 gap-2 w-full max-w-2xl mx-auto">
        <input
            type="text"
            wire:model.defer="searchInput"
            wire:keydown.enter="doSearch"
            placeholder="Search for a product..."
            class="border border-gray-300 rounded px-4 py-2 flex-1 shadow focus:outline-none focus:ring-2 focus:ring-blue-200" />
        <button
            wire:click="doSearch"
            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded shadow transition w-32">
            Search
        </button>

    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($products as $product)
        <div class="bg-white shadow-lg rounded-lg overflow-hidden flex flex-col items-center p-4 hover:scale-105 transition-transform w-full">
            <img src="{{ $product->image ?? 'https://via.placeholder.com/150' }}"
                alt="{{ $product->name }}"
                class="w-32 h-32 object-cover mb-4 rounded-md">
            <h4 class="text-lg font-semibold mb-2 text-center break-words">{{ $product->name }}</h4>
            <p class="text-gray-600 text-sm mb-4 text-center break-words line-clamp-3">{{ $product->description }}</p>
            <span class="text-green-600 font-bold text-lg mb-2">{{ $product->price }} ₪</span>
            <button
                wire:click="addToCart({{ $product->id }})"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded mt-2 transition">
                Add to Cart
            </button>
        </div>
        @endforeach
    </div>

    @if(count($products) == 0)
    <div class="text-center text-gray-400 py-10 text-lg">
        No products found matching your search.
    </div>
    @endif

    <div
    x-data="{ show: false, message: '', type: 'success' }"
    x-on:toast.window="
        message = $event.detail.message;
        type = $event.detail.type ?? 'success';
        show = true;
        setTimeout(() => show = false, 3000);
    "
    x-show="show"
    :class="type == 'success'
        ? 'bg-green-100 border-green-400 text-green-700'
        : 'bg-red-100 border-red-400 text-red-700'"
    class="fixed bottom-4 right-4 z-50 px-4 py-2 border rounded shadow w-80 max-w-full text-center transition-all duration-300"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-4"
>
    <span x-text="message"></span>
</div>


</div>