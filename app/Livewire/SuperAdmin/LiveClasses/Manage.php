<?php

namespace App\Livewire\SuperAdmin\LiveClasses;

use App\Models\AuditLog;
use App\Models\LiveClass;
use App\Models\LiveClassAttendee;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.super-admin')]
#[Title('Live Classes & WebRTC Monitor - Super Admin')]
class Manage extends Component
{
    use WithPagination;

    public string $statusFilter = '';
    public ?LiveClass $selectedClassForAttendance = null;
    public $attendees = [];

    public function updatedStatusFilter() { $this->resetPage(); }

    public function updateClassStatus(string $classId, string $status)
    {
        $liveClass = LiveClass::findOrFail($classId);
        $liveClass->update(['status' => $status]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'live_class_status_changed_by_super_admin',
            'auditable_type' => LiveClass::class,
            'auditable_id' => $classId,
            'new_values' => ['status' => $status],
            'ip_address' => request()->ip(),
        ]);

        session()->flash('status', "Live Class status updated to " . strtoupper($status));
    }

    public function viewAttendance(string $classId)
    {
        $this->selectedClassForAttendance = LiveClass::with(['course', 'trainer'])->findOrFail($classId);
        $this->attendees = LiveClassAttendee::with('student')->where('live_class_id', $classId)->get();
    }

    public function correctAttendanceStatus(string $attendeeId, string $newStatus)
    {
        $attendee = LiveClassAttendee::findOrFail($attendeeId);
        $attendee->update(['attendance_status' => $newStatus]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'attendance_manually_corrected',
            'auditable_type' => LiveClassAttendee::class,
            'auditable_id' => $attendeeId,
            'new_values' => ['attendance_status' => $newStatus],
            'ip_address' => request()->ip(),
        ]);

        if ($this->selectedClassForAttendance) {
            $this->attendees = LiveClassAttendee::with('student')->where('live_class_id', $this->selectedClassForAttendance->id)->get();
        }

        session()->flash('status', "Attendance status corrected to " . strtoupper($newStatus));
    }

    public function render()
    {
        $query = LiveClass::with(['course', 'trainer', 'attendees']);

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $liveClasses = $query->orderBy('start_at', 'desc')->paginate(10);

        return view('livewire.super-admin.live-classes.manage', [
            'liveClasses' => $liveClasses,
        ]);
    }
}
