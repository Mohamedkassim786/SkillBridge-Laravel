<?php

namespace App\Domain\Student\Services;

use App\Domain\Student\Contracts\StudentDashboardRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class StudentDashboardService
{
    public function __construct(
        protected StudentDashboardRepositoryInterface $repository
    ) {}

    public function getCachedDashboardPayload(User $user): array
    {
        return Cache::remember("student:dashboard_payload:{$user->id}", 300, function () use ($user) {
            return [
                'stats' => $this->repository->getLearningStats($user),
                'active_course' => $this->repository->getLastActiveCourse($user),
                'career_progress' => $this->repository->getCareerProgress($user),
                'ai_insight' => $this->repository->getAIInsights($user),
            ];
        });
    }

    public function getGreetingTime(): string
    {
        $hour = (int) date('H');
        if ($hour < 12) {
            return 'Good Morning';
        }
        if ($hour < 17) {
            return 'Good Afternoon';
        }

        return 'Good Evening';
    }
}
