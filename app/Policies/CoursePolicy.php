<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;

class CoursePolicy
{
    public function view(User $user, Course $course): bool
    {
        return Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->exists();
    }

    public function learn(User $user, Course $course): bool
    {
        return $this->view($user, $course);
    }

    public function downloadResource(User $user, Course $course): bool
    {
        return $this->view($user, $course);
    }

    public function submitReview(User $user, Course $course): bool
    {
        $enrollment = Enrollment::where('user_id', $user->id)->where('course_id', $course->id)->first();

        return $enrollment && ($enrollment->progress_percent >= 100 || $enrollment->status === 'completed');
    }
}
