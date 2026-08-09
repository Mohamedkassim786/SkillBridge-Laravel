<?php

namespace App\Livewire\SuperAdmin\Admins;

use App\Models\AuditLog;
use App\Models\LoginHistory;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.super-admin')]
#[Title('Multi-Admin Management - Super Admin')]
class Manage extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $role = 'admin';

    // Permissions toggles
    public array $selectedPermissions = [
        'users.view', 'courses.approve', 'jobs.approve', 'reports.view'
    ];

    public bool $showCreateModal = false;
    public ?User $selectedAdminForHistory = null;
    public $loginHistory = [];

    public function openCreateModal()
    {
        $this->reset(['name', 'email', 'password']);
        $this->showCreateModal = true;
    }

    public function createAdmin()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $admin = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        $admin->assignRole($this->role);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'admin_created',
            'auditable_type' => User::class,
            'auditable_id' => $admin->id,
            'new_values' => ['role' => $this->role, 'email' => $this->email],
            'ip_address' => request()->ip(),
        ]);

        session()->flash('status', "Admin account created for {$admin->name}.");
        $this->showCreateModal = false;
    }

    public function viewLoginHistory(string $adminId)
    {
        $this->selectedAdminForHistory = User::findOrFail($adminId);
        $this->loginHistory = LoginHistory::where('user_id', $adminId)->latest()->take(10)->get();
    }

    public function revokeSessions(string $adminId)
    {
        DB::table('sessions')->where('user_id', $adminId)->delete();

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'admin_sessions_revoked',
            'auditable_type' => User::class,
            'auditable_id' => $adminId,
            'ip_address' => request()->ip(),
        ]);

        session()->flash('status', 'Admin sessions revoked.');
    }

    public function render()
    {
        $admins = User::role(['admin', 'super_admin'])->with(['roles', 'loginHistories'])->get();

        $availablePermissions = [
            'users.view', 'users.create', 'users.update', 'users.delete',
            'courses.approve', 'courses.delete', 'jobs.approve', 'payments.refund',
            'reports.view', 'settings.update', 'live_classes.manage', 'admins.manage', 'system.manage'
        ];

        return view('livewire.super-admin.admins.manage', [
            'admins' => $admins,
            'availablePermissions' => $availablePermissions,
        ]);
    }
}
