<?php

namespace App\Livewire\Admin\Enrollments;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Admin - Student Enrollments Manager')]
class Manage extends Component
{
    public ?string $user_id = null;
    public ?string $course_id = null;
    public bool $showModal = false;
    public string $search = '';

    public function mount()
    {
        $user = auth()->user();
        if (! $user || ! $user->hasAnyRole(['admin', 'super_admin'])) {
            abort(403, 'Unauthorized access to Enrollment Management.');
        }

        $firstStudent = User::role('student')->first();
        if ($firstStudent) {
            $this->user_id = $firstStudent->id;
        }

        $firstCourse = Course::first();
        if ($firstCourse) {
            $this->course_id = $firstCourse->id;
        }
    }

    public function openCreateModal()
    {
        $this->showModal = true;
    }

    public function enrollStudent()
    {
        $this->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $course = Course::findOrFail($this->course_id);

        $existing = Enrollment::where('user_id', $this->user_id)
            ->where('course_id', $this->course_id)
            ->first();

        if ($existing) {
            session()->flash('warning', 'Student is already enrolled in this course.');
            $this->showModal = false;

            return;
        }

        Enrollment::create([
            'user_id' => $this->user_id,
            'course_id' => $this->course_id,
            'course_version_id' => $course->current_version_id,
            'progress_percent' => 0,
            'status' => 'active',
        ]);

        $student = User::find($this->user_id);
        session()->flash('status', "Enrolled student {$student?->name} into '{$course->title}'!");

        $this->showModal = false;
    }

    public function cancelEnrollment(string $enrollmentId)
    {
        $enr = Enrollment::find($enrollmentId);
        if ($enr) {
            $enr->delete();
            session()->flash('status', 'Enrollment revoked.');
        }
    }

    public function render()
    {
        $query = Enrollment::with(['user', 'course']);

        if ($this->search) {
            $query->whereHas('user', function ($q) {
                $q->where('first_name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            })->orWhereHas('course', function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%');
            });
        }

        $enrollments = $query->orderBy('created_at', 'desc')->get();
        $students = User::role('student')->get();
        $courses = Course::all();

        return view('livewire.admin.enrollments.manage', [
            'enrollments' => $enrollments,
            'students' => $students,
            'courses' => $courses,
        ]);
    }
}
