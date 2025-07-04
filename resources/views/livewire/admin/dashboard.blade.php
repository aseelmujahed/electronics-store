
<div class="max-w-2xl mx-auto py-10 px-2 sm:px-4">
    <h1 class="text-3xl font-bold mb-8">Admin Dashboard</h1>
    <div class="bg-white rounded shadow p-6">
        <p class="mb-6 text-gray-600">
            Welcome, {{ auth()->user()->name }}! Manage your store's products here.
        </p>
        <livewire:admin.products-manage />
    </div>
</div>