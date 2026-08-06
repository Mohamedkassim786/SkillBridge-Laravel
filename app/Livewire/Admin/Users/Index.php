<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('User Management - Admin Portal')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $roleFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }

    public function suspendUser(string $userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->update(['status' => 'suspended']);
            session()->flash('status', "User {$user->email} has been suspended.");
        }
    }

    public function activateUser(string $userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->update(['status' => 'active']);
            session()->flash('status', "User {$user->email} has been activated.");
        }
    }

    public function deleteUser(string $userId)
    {
        $user = User::find($userId);
        if ($user) {
            $email = $user->email;
            $user->delete();
            session()->flash('status', "User {$email} has been deleted.");
        }
    }

    public function render()
    {
        $query = User::with('roles');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('first_name', 'like', '%' . $this->search . '%')
                  ->orWhere('last_name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->roleFilter) {
            $query->role($this->roleFilter);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.admin.users.index', compact('users'));
    }
}
