<?php

namespace App\Livewire;

use Livewire\Component;
use Stancl\Tenancy\Database\Models\Tenant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SuperAdminDashboard extends Component
{
    public $tenants;
    public $showCreateForm = false;
    public $name, $domain, $admin_email, $admin_password;
    public $successMessage;

    public $showAdminsModal = false;
    public $admins = [];
    public $selectedTenant = null;
    public $adminEmail = '';
    public $adminPassword = '';
    public $adminSuccess = '';

    public function mount()
    {
        $this->refreshTenants();
    }

    public function refreshTenants()
    {
        $this->tenants = Tenant::all();
    }

    public function showCreateTenantForm()
    {
        $this->resetForm();
        $this->showCreateForm = true;
    }

    public function createTenant()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:100|unique:tenants,id',
            'domain' => 'required|string|max:100|unique:domains,domain',
            'admin_email' => 'required|email',
            'admin_password' => 'required|string|min:6',
        ]);


        $tenant = \Stancl\Tenancy\Database\Models\Tenant::create([
            'id' => $this->name, 
        ]);

        \Stancl\Tenancy\Database\Models\Domain::create([
            'domain' => $this->domain,
            'tenant_id' => $tenant->id,
        ]);

        \App\Models\User::create([
            'name' => 'Admin',
            'email' => $this->admin_email,
            'password' => Hash::make($this->admin_password),
            'role' => 'admin',
            'tenant_id' => $tenant->id,
        ]);

        $this->successMessage = "Tenant created successfully!";
        $this->showCreateForm = false;
        $this->refreshTenants();
        $this->resetForm();
    }

    public $showDeleteModal = false;
    public $tenantToDelete = null;

    public function confirmDeleteTenant($tenantId)
    {
        $this->tenantToDelete = $tenantId;
        $this->showDeleteModal = true;
    }

    public function deleteTenantConfirmed()
    {
        if ($this->tenantToDelete) {
            $tenant = \Stancl\Tenancy\Database\Models\Tenant::findOrFail($this->tenantToDelete);
            $tenant->delete();

            $this->successMessage = "Tenant deleted successfully!";
            $this->refreshTenants();
            $this->showDeleteModal = false;
            $this->tenantToDelete = null;
        }
    }

    public function resetForm()
    {
        $this->name = '';
        $this->domain = '';
        $this->admin_email = '';
        $this->admin_password = '';
    }

    public function viewAdmins($tenantId)
    {
        $this->selectedTenant = Tenant::find($tenantId);
        $this->admins = [];
        $this->adminEmail = '';
        $this->adminPassword = '';
        $this->adminSuccess = '';

        if ($this->selectedTenant) {
            $this->admins = \App\Models\User::where('role', 'admin')
                ->where('tenant_id', $this->selectedTenant->id)
                ->get();
            $this->showAdminsModal = true;
        }
    }

    public function closeAdminsModal()
    {
        $this->showAdminsModal = false;
    }

    public function addAdmin()
    {
        $this->validate([
            'adminEmail' => 'required|email',
            'adminPassword' => 'required|string|min:6'
        ]);

        if ($this->selectedTenant && $this->selectedTenant->id) {
            $exists = \App\Models\User::where('email', $this->adminEmail)
                ->where('tenant_id', $this->selectedTenant->id)
                ->exists();

            if (!$exists) {
                logger('will_create', [
                    'email' => $this->adminEmail,
                    'role' => 'admin',
                    'tenant_id' => $this->selectedTenant?->id,
                ]);

                $user = \App\Models\User::create([
                    'name' => 'Admin',
                    'email' => $this->adminEmail,
                    'password' => Hash::make($this->adminPassword),
                    'role' => 'admin',
                    'tenant_id' => $this->selectedTenant->id ?? 'NOT_SET',
                ]);

                logger('created_user', $user->toArray());

                $this->adminSuccess = "Admin added successfully!";
            } else {
                $this->adminSuccess = "Admin with this email already exists for this tenant!";
            }
            $this->admins = \App\Models\User::where('role', 'admin')
                ->where('tenant_id', $this->selectedTenant->id)
                ->get();

            $this->adminEmail = '';
            $this->adminPassword = '';
        } else {
            $this->adminSuccess = "No tenant selected!";
        }
    }

    public function deleteAdmin($adminId)
    {
        if ($this->selectedTenant) {
            $admin = \App\Models\User::where('role', 'admin')
                ->where('tenant_id', $this->selectedTenant->id)
                ->where('id', $adminId)
                ->first();
            if ($admin) $admin->delete();
            $this->admins = \App\Models\User::where('role', 'admin')
                ->where('tenant_id', $this->selectedTenant->id)
                ->get();
        }
    }
    public function render()
    {
        return view('livewire.super-admin-dashboard')->layout('layouts.app');
    }
}
