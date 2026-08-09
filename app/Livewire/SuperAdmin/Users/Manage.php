<?php

namespace App\Livewire\SuperAdmin\Users;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.super-admin')]
#[Title('All Users Management - Super Admin')]
class Manage extends Component
{
    use WithPagination;

    public string $search = '';
    public string $role = '';
    public string $status = '';

    // Action Modal States
    public ?User $selectedUser = null;
    public string $newPassword = '';
    public bool $showPasswordModal = false;

    public function updatedSearch() { $this->resetPage(); }
    public function updatedRole() { $this->resetPage(); }
    public function updatedStatus() { $this->resetPage(); }

    public function toggleStatus(string $userId)
    {
        $user = User::findOrFail($userId);
        $newStatus = $user->status === 'active' ? 'suspended' : 'active';
        $user->update(['status' => $newStatus]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'user_status_changed',
            'auditable_type' => User::class,
            'auditable_id' => $user->id,
            'new_values' => ['status' => $newStatus],
            'ip_address' => request()->ip(),
        ]);

        session()->flash('status', "User {$user->name} status changed to " . strtoupper($newStatus));
    }

    public function forceLogout(string $userId)
    {
        DB::table('sessions')->where('user_id', $userId)->delete();

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'force_logout_user',
            'auditable_type' => User::class,
            'auditable_id' => $userId,
            'ip_address' => request()->ip(),
        ]);

        session()->flash('status', 'User sessions forcefully terminated across all devices.');
    }

    public function openPasswordModal(string $userId)
    {
        $this->selectedUser = User::findOrFail($userId);
        $this->newPassword = '';
        $this->showPasswordModal = true;
    }

    public function resetPassword()
    {
        $this->validate([
            'newPassword' => 'required|string|min:8',
        ]);

        if ($this->selectedUser) {
            $this->selectedUser->update([
                'password' => Hash::make($this->newPassword),
            ]);

            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'password_reset_by_super_admin',
                'auditable_type' => User::class,
                'auditable_id' => $this->selectedUser->id,
                'ip_address' => request()->ip(),
            ]);

            session()->flash('status', "Password reset successfully for {$this->selectedUser->name}.");
        }

        $this->showPasswordModal = false;
    }

    public function deleteUser(string $userId)
    {
        $user = User::findOrFail($userId);
        if ($user->hasRole('super_admin') && User::role('super_admin')->count() <= 1) {
            session()->flash('error', 'Cannot delete the primary Super Admin account.');
            return;
        }

        $user->delete();

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'user_deleted',
            'auditable_type' => User::class,
            'auditable_id' => $userId,
            'ip_address' => request()->ip(),
        ]);

        session()->flash('status', 'User account deleted cleanly per retention policy.');
    }

    public function render()
    {
        $query = User::with(['roles', 'profile']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('id', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->role) {
            $query->role($this->role);
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('livewire.super-admin.users.manage', [
            'users' => $users,
        ]);
    }
}
