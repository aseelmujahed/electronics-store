<div class="max-w-2xl mx-auto py-10 px-2 sm:px-4">
    @php
    $align = app()->getLocale() == 'ar' ? 'text-right' : 'text-left';
    @endphp
    <h1 class="text-3xl font-bold mb-8 text-center">{{ __('messages.admin_dashboard') }}</h1>
    <div class="bg-white rounded shadow p-6">
        <p class="mb-6 text-gray-600 {{ $align }}">
            {{ __('messages.welcome_admin', ['name' => auth()->user()->name]) }}
        </p>
        <livewire:admin.products-manage />
    </div>
</div>