<?php

namespace App\Domain\Student\Contracts;

use App\Models\Course;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface CourseRepositoryInterface
{
    public function getStudentCourses(User $user, array $filters = []): LengthAwarePaginator;

    public function findWithDetails(string $courseId, ?User $user = null): ?Course;

    public function getCourseResources(string $courseId): array;

    public function isEnrolled(User $user, string $courseId): bool;
}
