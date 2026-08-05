<?php

namespace App\Livewire\Public\Courses;

use App\Models\Course;
use App\Models\Enrollment;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.public')]
#[Title('Course Details - SkillBridge')]
class Show extends Component
{
    public string $courseId;

    public function mount(string $courseId)
    {
        $this->courseId = $courseId;
    }

    public function enroll()
    {
        $user = auth()->user();
        if (! $user) {
            return redirect()->route('login');
        }

        $course = Course::findOrFail($this->courseId);

        Enrollment::firstOrCreate(
            ['user_id' => $user->id, 'course_id' => $course->id],
            [
                'course_version_id' => $course->current_version_id,
                'progress_percent' => 0,
                'status' => 'active',
            ]
        );

        return redirect()->route('student.courses.player', ['courseId' => $course->id]);
    }

    public function render()
    {
        $course = Course::with(['category', 'trainer', 'currentVersion.modules.lessons'])->findOrFail($this->courseId);
        $relatedCourses = Course::where('category_id', $course->category_id)->where('id', '!=', $course->id)->take(4)->get();
        if ($relatedCourses->count() < 4) {
            $relatedCourses = Course::where('id', '!=', $course->id)->take(4)->get();
        }

        return view('livewire.public.courses.show', [
            'course' => $course,
            'relatedCourses' => $relatedCourses,
        ]);
    }
}
