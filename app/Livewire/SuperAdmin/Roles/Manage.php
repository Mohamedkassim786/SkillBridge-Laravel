<?php

namespace App\Livewire\SuperAdmin\Roles;

use App\Models\AuditLog;
use App\Models\Permission;
use App\Models\Role;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.super-admin')]
#[Title('Roles & Permissions Matrix - Super Admin')]
class Manage extends Component
{
    public string $newRoleName = '';
    public bool $showRoleModal = false;

    public function createRole()
    {
        $this->validate([
            'newRoleName' => 'required|string|max:50|unique:roles,name',
        ]);

        $role = Role::create([
            'name' => strtolower(str_replace(' ', '_', $this->newRoleName)),
            'guard_name' => 'web',
        ]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'role_created',
            'auditable_type' => Role::class,
            'auditable_id' => $role->id,
            'new_values' => ['name' => $role->name],
            'ip_address' => request()->ip(),
        ]);

        session()->flash('status', "New custom role '{$role->name}' created successfully.");
        $this->showRoleModal = false;
        $this->newRoleName = '';
    }

    public function render()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();

        $permissionGroups = [
            'User & Accounts' => ['users.view', 'users.create', 'users.update', 'users.delete'],
            'Courses Pipeline' => ['courses.approve', 'courses.delete', 'courses.create', 'courses.update'],
            'Jobs & Hiring' => ['jobs.approve', 'jobs.delete', 'companies.approve'],
            'Finance & Payouts' => ['payments.refund', 'payouts.approve', 'finance.reports'],
            'Live Classes & Jitsi' => ['live_classes.manage', 'live_classes.approve'],
            'System Security' => ['settings.update', 'admins.manage', 'system.manage', 'backups.manage'],
        ];

        return view('livewire.super-admin.roles.manage', [
            'roles' => $roles,
            'permissions' => $permissions,
            'permissionGroups' => $permissionGroups,
        ]);
    }
}
