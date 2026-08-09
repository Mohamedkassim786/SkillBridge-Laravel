<?php

namespace App\Livewire\SuperAdmin\Trainers;

use App\Models\AuditLog;
use App\Models\User;
use App\Models\UserProfile;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.super-admin')]
#[Title('Trainer Management & Approval Pipeline - Super Admin')]
class Workflow extends Component
{
    use WithPagination;

    public string $search = '';
    public string $verification_status = '';

    public function updatedSearch() { $this->resetPage(); }
    public function updatedVerificationStatus() { $this->resetPage(); }

    public function updateTrainerVerification(string $userId, string $newStatus)
    {
        $user = User::findOrFail($userId);
        $user->update(['status' => $newStatus]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'trainer_verification_changed',
            'auditable_type' => User::class,
            'auditable_id' => $userId,
            'new_values' => ['status' => $newStatus],
            'ip_address' => request()->ip(),
        ]);

        session()->flash('status', "Trainer {$user->name} status changed to " . strtoupper($newStatus));
    }

    public function render()
    {
        $query = User::role('staff')->with(['profile', 'assignedCourses']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('first_name', 'like', '%' . $this->search . '%')
                  ->orWhere('last_name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->verification_status) {
            $query->where('status', $this->verification_status);
        }

        $trainers = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.super-admin.trainers.workflow', [
            'trainers' => $trainers,
        ]);
    }
}
