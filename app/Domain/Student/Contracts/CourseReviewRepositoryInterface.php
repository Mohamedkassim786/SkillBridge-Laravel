<?php

namespace App\Domain\Student\Contracts;

use App\Models\CourseReview;
use App\Models\User;
use Illuminate\Support\Collection;

interface CourseReviewRepositoryInterface
{
    public function getReviewsForCourse(string $courseId): Collection;

    public function getAverageRating(string $courseId): float;

    public function getRatingStatistics(string $courseId): array;

    public function createOrUpdateReview(User $user, string $courseId, int $rating, string $reviewText): CourseReview;

    public function deleteReview(User $user, string $reviewId): bool;
}
