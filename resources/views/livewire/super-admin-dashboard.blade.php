<div class="max-w-3xl mx-auto py-10 px-4">

    <div class="flex justify-end mb-6">
        <form method="POST" action="{{ route('superadmin.logout') }}">
            @csrf
            <button
                class="bg-gray-800 text-white px-6 py-2 rounded-xl shadow hover:bg-gray-900 text-lg font-semibold transition tracking-wide"
                type="submit">
                {{ __('messages.logout') }}
            </button>
        </form>
    </div>

    <h1 class="text-3xl font-bold mb-8 text-center">{{ __('messages.super_admin_dashboard') }}</h1>

    <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100 mb-10 max-w-2xl mx-auto">
        <div class="mb-6">
            <span class="text-xl font-semibold text-gray-800 block text-center w-full">
                {{ __('messages.manage_tenants') }}
            </span>
        </div>
        @if ($successMessage)
        <div class="bg-green-100 text-green-700 p-2 mb-6 rounded text-center font-semibold">
            {{ $successMessage }}
        </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full bg-white rounded shadow border border-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b text-center font-semibold">{{ __('messages.id') }}</th>
                        <th class="px-4 py-2 border-b text-center font-semibold">{{ __('messages.domain') }}</th>
                        <th class="px-4 py-2 border-b text-center font-semibold">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tenants as $tenant)
                    <tr class="hover:bg-indigo-50">
                        <td class="px-4 py-3 border-b text-center">{{ $tenant->id }}</td>
                        @php
                        $domain = \Stancl\Tenancy\Database\Models\Domain::where('tenant_id', $tenant->id)->first();
                        @endphp
                        <td class="px-4 py-3 border-b text-center">{{ $domain->domain ?? '-' }}</td>
                        <td class="px-4 py-3 border-b text-center">
                            <div class="flex flex-col sm:flex-row gap-2 justify-center">
                                <button
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-0.9 py-2 rounded-lg font-medium transition mt-2"
                                    wire:click="viewAdmins('{{ $tenant->id }}')">
                                    {{ __('messages.view_admins') }}
                                </button>
                                <button
                                    class="bg-red-600 hover:bg-red-700 text-white px-0.9 py-2 rounded-lg font-medium transition  mb-2"
                                    wire:click="confirmDeleteTenant('{{ $tenant->id }}')">
                                    {{ __('messages.delete') }}
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-gray-400 py-6">{{ __('messages.no_tenants') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="flex justify-center mt-8">
                <button
                    wire:click="showCreateTenantForm"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-2 rounded-lg font-medium transition mt-3">
                    {{ __('messages.create_tenant') }}
                </button>
            </div>
        </div>
        @if ($showCreateForm)
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
            <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md relative">
                <h3 class="text-xl font-bold mb-6 text-gray-800 text-center">
                    {{ __('messages.create_tenant') }}
                </h3>
                <form wire:submit.prevent="createTenant" class="space-y-4">
                    <div>
                        <label class="block mb-1 font-semibold">{{ __('messages.tenant_name') }}</label>
                        <input type="text" wire:model.defer="name" class="border rounded px-3 py-2 w-full" required placeholder="e.g. store1">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block mb-1 font-semibold">{{ __('messages.domain') }}</label>
                        <input type="text" wire:model.defer="domain" class="border rounded px-3 py-2 w-full" required placeholder="e.g. store1.localhost">
                        @error('domain') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block mb-1 font-semibold">{{ __('messages.admin_email') }}</label>
                        <input type="email" wire:model.defer="admin_email" class="border rounded px-3 py-2 w-full" required>
                        @error('admin_email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block mb-1 font-semibold">{{ __('messages.admin_password') }}</label>
                        <input type="password" wire:model.defer="admin_password" class="border rounded px-3 py-2 w-full" required>
                        @error('admin_password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex gap-4 mt-6 justify-center">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-indigo-700 font-semibold transition">
                            {{ __('messages.create_tenant') }}
                        </button>
                        <button type="button" wire:click="$set('showCreateForm', false)"
                            class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300 font-semibold transition">
                            {{ __('messages.cancel') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif

        @if ($showDeleteModal && $tenantToDelete)
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8 flex flex-col items-center relative">
                <h3 class="text-xl font-bold mb-4 text-center text-gray-800 leading-snug">
                    {{ __('messages.are_you_sure_delete_tenant') }}
                </h3>
                <div class="flex gap-4 mt-2 w-full justify-center">
                    <button
                        wire:click="deleteTenantConfirmed"
                        class="bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700 font-semibold transition">
                        {{ __('messages.yes_delete') }}
                    </button>
                    <button
                        wire:click="$set('showDeleteModal', false)"
                        class="bg-gray-200 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-300 font-semibold transition">
                        {{ __('messages.cancel') }}
                    </button>
                </div>
            </div>
        </div>
        @endif

        @if ($showAdminsModal && $selectedTenant)
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
            <div class="bg-white rounded-2xl shadow-2xl p-8 pt-14 w-full max-w-lg relative">
                <button type="button" wire:click="closeAdminsModal"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-2xl font-bold focus:outline-none transition">
                    &times;
                </button>
                <h3 class="text-xl font-bold mb-6 text-gray-800 mt-2 text-center">
                    {{ __('messages.admins_for_tenant') }} <span class="text-indigo-600">{{ $selectedTenant->id }}</span>
                </h3>
                @if ($adminSuccess)
                <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">{{ $adminSuccess }}</div>
                @endif
                <form wire:submit.prevent="addAdmin" class="mb-4 flex flex-col sm:flex-row gap-2">
                    <input type="email" wire:model.defer="adminEmail" placeholder="{{ __('messages.admin_email') }}"
                        class="border rounded px-3 py-2 flex-1" required>
                    <input type="password" wire:model.defer="adminPassword" placeholder="{{ __('messages.admin_password') }}"
                        class="border rounded px-3 py-2 flex-1" required>
                    <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 whitespace-nowrap">
                        {{ __('messages.add_admin') }}
                    </button>
                </form>
                <table class="w-full bg-white rounded">
                    <thead>
                        <tr>
                            <th class="px-2 py-2 border-b text-center">{{ __('messages.email') }}</th>
                            <th class="px-2 py-2 border-b text-center">{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($admins as $admin)
                        <tr>
                            <td class="px-2 py-2 border-b text-center">{{ $admin->email }}</td>
                            <td class="px-2 py-2 border-b text-center">
                                <button wire:click="deleteAdmin({{ $admin->id }})"
                                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                    {{ __('messages.delete') }}
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center text-gray-400 py-4">{{ __('messages.no_admins') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
