<div class="max-w-3xl mx-auto py-8">
    @php
    $align = app()->getLocale() == 'ar' ? 'text-right' : 'text-left';
    @endphp
    <h2 class="text-2xl font-bold mb-4 text-center">
        {{ __('messages.manage_products') }}
    </h2>

    @if (session()->has('message'))
    <div class="bg-green-100 text-green-700 p-2 mb-4 rounded {{ $align }}">
        {{ session('message') }}
    </div>
    @endif

    <div class="mb-4 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
        <button wire:click="showAddForm" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            {{ __('messages.add_product') }}
        </button>
    </div>


    @if ($showForm)
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-2xl p-8 pt-12 w-full max-w-md relative">

            <form wire:submit.prevent="save">
                <div class="mb-4">
                    <label class="block mb-1 font-semibold {{ $align }}">{{ __('messages.name') }}</label>
                    <input type="text" wire:model.defer="name" class="border rounded w-full px-3 py-2 focus:ring ">
                    @error('name') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-semibold {{ $align }}">{{ __('messages.description') }}</label>
                    <textarea wire:model.defer="description" class="border rounded w-full px-3 py-2 focus:ring"></textarea>
                    @error('description') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-semibold {{ $align }}">{{ __('messages.price') }}</label>
                    <input type="number" step="0.01" wire:model.defer="price" class="border rounded w-full px-3 py-2 focus:ring ">
                    @error('price') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="mb-6">
                    <label class="block mb-1 font-semibold {{ $align }}">{{ __('messages.image_url') }}</label>
                    <input type="text" wire:model.defer="image" class="border rounded w-full px-3 py-2 focus:ring ">
                    @error('image') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="flex gap-2 justify-end">
                    <button type="button" wire:click="resetFields" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded {{ $align }}">
                        {{ __('messages.cancel') }}
                    </button>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded {{ $align }}">
                        {{ $isEdit ? __('messages.update') : __('messages.add_product') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <div class="max-w-3xl mx-auto py-8" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <table class="w-full bg-white shadow rounded">
            <thead>
                <tr>
                    <th class="px-2 py-2 border-b text-center">{{ __('messages.name') }}</th>
                    <th class="px-2 py-2 border-b text-center">{{ __('messages.price') }}</th>
                    <th class="px-2 py-2 border-b text-center">{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td class="px-2 py-2 border-b text-center">{{ $product->name }}</td>
                    <td class="px-2 py-2 border-b text-center">{{ number_format($product->price, 2) }}</td>
                    <td class="px-2 py-2 border-b text-center">
                        <div class="flex gap-2 justify-center">
                            <button wire:click="showEditForm({{ $product->id }})"
                                class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                {{ __('messages.edit_product') }}
                            </button>
                            <button wire:click="delete({{ $product->id }})"
                                class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                {{ __('messages.delete') }}
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
                @if($products->isEmpty())
                <tr>
                    <td colspan="3" class="text-center text-gray-400 py-4">{{ __('messages.no_products') }}</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

</div>