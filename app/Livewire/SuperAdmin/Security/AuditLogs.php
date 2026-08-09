<?php

namespace App\Livewire\SuperAdmin\Security;

use App\Models\AuditLog;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.super-admin')]
#[Title('Audit Trail & Activity Logs - Super Admin')]
class AuditLogs extends Component
{
    use WithPagination;

    public string $actionFilter = '';
    public string $search = '';

    public function updatedActionFilter() { $this->resetPage(); }
    public function updatedSearch() { $this->resetPage(); }

    public function render()
    {
        $query = AuditLog::with('user');

        if ($this->actionFilter) {
            $query->where('action', $this->actionFilter);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('ip_address', 'like', '%' . $this->search . '%')
                  ->orWhere('action', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function ($uq) {
                      $uq->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        $auditLogs = $query->orderBy('created_at', 'desc')->paginate(15);
        $distinctActions = AuditLog::select('action')->distinct()->pluck('action');

        return view('livewire.super-admin.security.audit-logs', [
            'auditLogs' => $auditLogs,
            'distinctActions' => $distinctActions,
        ]);
    }
}
