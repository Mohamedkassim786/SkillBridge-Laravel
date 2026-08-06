<?php

namespace App\Livewire\Admin\ActivityLogs;

use App\Models\AuditLog;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Activity Logs - SkillBridge Admin')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $selectedUser = '';
    public string $selectedAction = '';
    public string $dateRange = '7_days';
    public int $perPage = 30;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedUser()
    {
        $this->resetPage();
    }

    public function updatingSelectedAction()
    {
        $this->resetPage();
    }

    public function clearOldLogs()
    {
        AuditLog::where('created_at', '<', now()->subDays(30))->delete();
        session()->flash('status', 'Audit logs older than 30 days cleared from MySQL 8 database.');
    }

    public function render()
    {
        $query = AuditLog::with('user');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('action', 'like', '%' . $this->search . '%')
                  ->orWhere('ip_address', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function ($u) {
                      $u->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->selectedUser) {
            $query->where('user_id', $this->selectedUser);
        }

        if ($this->selectedAction) {
            $query->where('action', 'like', '%' . $this->selectedAction . '%');
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate($this->perPage);
        $users = User::all();
        $totalLogsCount = AuditLog::count();
        $activeUsersCount = AuditLog::distinct('user_id')->count('user_id');

        return view('livewire.admin.activity-logs.index', compact(
            'logs',
            'users',
            'totalLogsCount',
            'activeUsersCount'
        ));
    }
}
