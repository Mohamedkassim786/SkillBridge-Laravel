<?php

namespace App\Domain\Student\Repositories;

use App\Domain\Student\Contracts\CourseReviewRepositoryInterface;
use App\Models\CourseReview;
use App\Models\User;
use Illuminate\Support\Collection;

class CourseReviewRepository implements CourseReviewRepositoryInterface
{
    public function getReviewsForCourse(string $courseId): Collection
    {
        return CourseReview::with('user')
            ->where('course_id', $courseId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getAverageRating(string $courseId): float
    {
        $avg = CourseReview::where('course_id', $courseId)->avg('rating');

        return $avg ? (float) round($avg, 1) : 5.0;
    }

    public function getRatingStatistics(string $courseId): array
    {
        $total = CourseReview::where('course_id', $courseId)->count();
        if ($total === 0) {
            return [
                'total' => 0,
                'average' => 5.0,
                '5_star' => 100,
                '4_star' => 0,
                '3_star' => 0,
                '2_star' => 0,
                '1_star' => 0,
            ];
        }

        $five = CourseReview::where('course_id', $courseId)->where('rating', 5)->count();
        $four = CourseReview::where('course_id', $courseId)->where('rating', 4)->count();
        $three = CourseReview::where('course_id', $courseId)->where('rating', 3)->count();
        $two = CourseReview::where('course_id', $courseId)->where('rating', 2)->count();
        $one = CourseReview::where('course_id', $courseId)->where('rating', 1)->count();

        return [
            'total' => $total,
            'average' => $this->getAverageRating($courseId),
            '5_star' => (int) round(($five / $total) * 100),
            '4_star' => (int) round(($four / $total) * 100),
            '3_star' => (int) round(($three / $total) * 100),
            '2_star' => (int) round(($two / $total) * 100),
            '1_star' => (int) round(($one / $total) * 100),
        ];
    }

    public function createOrUpdateReview(User $user, string $courseId, int $rating, string $reviewText): CourseReview
    {
        return CourseReview::updateOrCreate(
            [
                'user_id' => $user->id,
                'course_id' => $courseId,
            ],
            [
                'rating' => $rating,
                'review_text' => $reviewText,
            ]
        );
    }

    public function deleteReview(User $user, string $reviewId): bool
    {
        return (bool) CourseReview::where('id', $reviewId)->where('user_id', $user->id)->delete();
    }
}
