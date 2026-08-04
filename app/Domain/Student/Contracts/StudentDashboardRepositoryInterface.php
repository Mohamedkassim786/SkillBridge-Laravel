<?php

namespace App\Domain\Student\Contracts;

use App\Models\User;
use Illuminate\Support\Collection;

interface StudentDashboardRepositoryInterface
{
    public function getLearningStats(User $user): array;

    public function getLastActiveCourse(User $user): ?array;

    public function getUpcomingClasses(User $user, int $limit = 3): Collection;

    public function getPendingAssignments(User $user, int $limit = 4): Collection;

    public function getUpcomingQuizzes(User $user, int $limit = 4): Collection;

    public function getRecentCertificates(User $user, int $limit = 3): Collection;

    public function getRecommendedCourses(User $user, int $limit = 3): Collection;

    public function getRecommendedJobs(User $user, int $limit = 3): Collection;

    public function getCareerProgress(User $user): array;

    public function getCalendarEvents(User $user): Collection;

    public function getNotifications(User $user, int $limit = 5): Collection;

    public function getAIInsights(User $user): array;
}
