<?php

namespace App\Domain\Student\Services;

use App\Domain\Student\Contracts\CourseReviewRepositoryInterface;
use App\Models\CourseReview;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class ReviewService
{
    public function __construct(
        protected CourseReviewRepositoryInterface $reviewRepository
    ) {}

    public function submitReview(User $user, string $courseId, int $rating, string $reviewText): CourseReview
    {
        $enrollment = Enrollment::where('user_id', $user->id)->where('course_id', $courseId)->first();

        // Business Rule: Student MUST complete 100% of the course
        if (! $enrollment || ($enrollment->progress_percent < 100 && $enrollment->status !== 'completed')) {
            throw ValidationException::withMessages([
                'review' => 'Course reviews can only be submitted after 100% course completion.',
            ]);
        }

        return $this->reviewRepository->createOrUpdateReview($user, $courseId, $rating, $reviewText);
    }

    public function deleteReview(User $user, string $reviewId): bool
    {
        return $this->reviewRepository->deleteReview($user, $reviewId);
    }
}
