<?php

namespace App\Livewire\Student\Courses;

use App\Domain\Student\Contracts\CourseRepositoryInterface;
use App\Domain\Student\Contracts\CourseReviewRepositoryInterface;
use App\Models\Course;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.student')]
#[Title('Course Details - SkillBridge')]
class Show extends Component
{
    public Course $course;
    public string $activeTab = 'overview'; // overview, curriculum, outcomes, requirements, resources, instructor, reviews, faqs, certificate

    public function mount(string $courseId, CourseRepositoryInterface $courseRepository)
    {
        $user = auth()->user();

        // Business Rule: Student must be enrolled
        if (! $courseRepository->isEnrolled($user, $courseId)) {
            abort(403, 'Unauthorized access. You are not enrolled in this course.');
        }

        $found = $courseRepository->findWithDetails($courseId, $user);
        if (! $found) {
            abort(404, 'Course not found');
        }

        $this->course = $found;
        $this->authorize('view', $this->course);
    }

    public function render(
        CourseRepositoryInterface $courseRepository,
        CourseReviewRepositoryInterface $reviewRepository
    ) {
        $resources = $courseRepository->getCourseResources($this->course->id);
        $reviews = $reviewRepository->getReviewsForCourse($this->course->id);

        return view('livewire.student.courses.show', [
            'resources' => $resources,
            'reviews' => $reviews,
        ]);
    }
}
