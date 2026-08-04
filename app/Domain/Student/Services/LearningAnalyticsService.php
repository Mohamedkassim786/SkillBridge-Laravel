<?php

namespace App\Domain\Student\Services;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\LessonProgress;
use App\Models\Module;
use App\Models\User;

class LearningAnalyticsService
{
    public function getStudentAnalytics(User $user, ?Course $course = null): array
    {
        $watchSeconds = LessonProgress::where('user_id', $user->id)->sum('watch_time_seconds');
        $timeSpentHours = (float) round($watchSeconds / 3600, 1);

        $enrollments = Enrollment::where('user_id', $user->id)->get();
        $overallProgress = (int) round($enrollments->avg('progress_percent') ?? 0);

        if ($course) {
            $modules = $course->currentVersion?->modules ?? collect([]);
            $allLessons = $modules->pluck('lessons')->flatten();
            $totalSeconds = $allLessons->sum('duration');
            $courseWatchSeconds = LessonProgress::where('user_id', $user->id)
                ->whereIn('lesson_id', $allLessons->pluck('id'))
                ->sum('watch_time_seconds');

            $remainingSeconds = max(0, $totalSeconds - $courseWatchSeconds);
            $remainingHours = (float) round($remainingSeconds / 3600, 1);

            $moduleProgress = [];
            foreach ($modules as $module) {
                $modLessons = $module->lessons;
                $modTotal = $modLessons->count();
                $modDone = LessonProgress::where('user_id', $user->id)
                    ->whereIn('lesson_id', $modLessons->pluck('id'))
                    ->where('is_completed', true)
                    ->count();

                $moduleProgress[$module->id] = $modTotal > 0 ? (int) round(($modDone / $modTotal) * 100) : 0;
            }

            return [
                'overall_progress' => $overallProgress,
                'course_progress' => $course->enrollments->first()?->progress_percent ?? 0,
                'total_learning_hours' => $timeSpentHours,
                'time_spent_seconds' => $watchSeconds,
                'remaining_hours' => $remainingHours,
                'module_progress' => $moduleProgress,
                'learning_streak' => 5,
            ];
        }

        return [
            'overall_progress' => $overallProgress,
            'total_learning_hours' => $timeSpentHours,
            'time_spent_seconds' => $watchSeconds,
            'learning_streak' => 5,
        ];
    }
}
