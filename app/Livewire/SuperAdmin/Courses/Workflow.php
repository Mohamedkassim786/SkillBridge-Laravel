<?php

namespace App\Livewire\SuperAdmin\Courses;

use App\Models\AuditLog;
use App\Models\Course;
use App\Models\CourseVersion;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.super-admin')]
#[Title('Course Approval & Lifecycle Pipeline - Super Admin')]
class Workflow extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = '';

    public function updatedSearch() { $this->resetPage(); }
    public function updatedStatus() { $this->resetPage(); }

    public function updateCourseStatus(string $courseId, string $newStatus)
    {
        $course = Course::findOrFail($courseId);
        if ($course->currentVersion) {
            $isPublished = in_array($newStatus, ['published', 'approved']);
            $course->currentVersion->update(['is_published' => $isPublished]);
        }

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'course_status_changed',
            'auditable_type' => Course::class,
            'auditable_id' => $courseId,
            'new_values' => ['status' => $newStatus],
            'ip_address' => request()->ip(),
        ]);

        session()->flash('status', "Course status changed to " . strtoupper($newStatus));
    }

    public function render()
    {
        $query = Course::with(['category', 'currentVersion', 'trainer']);

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->status) {
            $isPub = ($this->status === 'published' || $this->status === 'approved');
            $query->whereHas('currentVersion', function ($q) use ($isPub) {
                $q->where('is_published', $isPub);
            });
        }

        $courses = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.super-admin.courses.workflow', [
            'courses' => $courses,
        ]);
    }
}
