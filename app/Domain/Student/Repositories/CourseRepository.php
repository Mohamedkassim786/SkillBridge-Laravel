<?php

namespace App\Domain\Student\Repositories;

use App\Domain\Student\Contracts\CourseRepositoryInterface;
use App\Models\Course;
use App\Models\CourseResource;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class CourseRepository implements CourseRepositoryInterface
{
    public function getStudentCourses(User $user, array $filters = []): LengthAwarePaginator
    {
        $query = Course::with([
            'category',
            'trainer.profile',
            'currentVersion.modules.lessons',
            'enrollments' => fn ($q) => $q->where('user_id', $user->id),
        ])->whereHas('enrollments', function ($q) use ($user, $filters) {
            $q->where('user_id', $user->id);
            if (! empty($filters['status']) && $filters['status'] !== 'all') {
                if ($filters['status'] === 'in_progress') {
                    $q->where('status', 'active');
                } elseif ($filters['status'] === 'completed') {
                    $q->where('status', 'completed');
                }
            }
        });

        // Search Filter
        if (! empty($filters['search'])) {
            $query->where('title', 'LIKE', '%'.$filters['search'].'%');
        }

        // Category Filter
        if (! empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        // Trainer Filter
        if (! empty($filters['trainer_id'])) {
            $query->where('trainer_id', $filters['trainer_id']);
        }

        // Difficulty Filter
        if (! empty($filters['difficulty'])) {
            $query->whereHas('currentVersion', function ($q) use ($filters) {
                $q->where('level', $filters['difficulty']);
            });
        }

        // Sorting
        $sort = $filters['sort'] ?? 'recently_accessed';
        if ($sort === 'highest_progress') {
            $query->join('enrollments', function ($join) use ($user) {
                $join->on('courses.id', '=', 'enrollments.course_id')
                    ->where('enrollments.user_id', '=', $user->id);
            })->orderBy('enrollments.progress_percent', 'desc')
                ->select('courses.*');
        } elseif ($sort === 'newest') {
            $query->orderBy('courses.created_at', 'desc');
        } else {
            // Default: recently_accessed
            $query->join('enrollments', function ($join) use ($user) {
                $join->on('courses.id', '=', 'enrollments.course_id')
                    ->where('enrollments.user_id', '=', $user->id);
            })->orderBy('enrollments.updated_at', 'desc')
                ->select('courses.*');
        }

        return $query->paginate(9);
    }

    public function findWithDetails(string $courseId, ?User $user = null): ?Course
    {
        return Course::with([
            'category',
            'trainer.profile',
            'currentVersion.modules.lessons' => function ($q) use ($user) {
                if ($user) {
                    $q->with(['progress' => fn ($pq) => $pq->where('user_id', $user->id)]);
                }
            },
            'enrollments' => function ($q) use ($user) {
                if ($user) {
                    $q->where('user_id', $user->id);
                }
            },
        ])->find($courseId);
    }

    public function getCourseResources(string $courseId): array
    {
        return CourseResource::where('course_id', $courseId)->get()->toArray();
    }

    public function isEnrolled(User $user, string $courseId): bool
    {
        return Enrollment::where('user_id', $user->id)->where('course_id', $courseId)->exists();
    }
}
