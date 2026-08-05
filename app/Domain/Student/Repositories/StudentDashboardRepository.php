<?php

namespace App\Domain\Student\Repositories;

use App\Domain\Student\Contracts\StudentDashboardRepositoryInterface;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\JobPosting;
use App\Models\LessonProgress;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class StudentDashboardRepository implements StudentDashboardRepositoryInterface
{
    public function getLearningStats(User $user): array
    {
        $purchased = Enrollment::where('user_id', $user->id)->count();
        $inProgress = Enrollment::where('user_id', $user->id)->where('status', 'active')->count();
        $completed = Enrollment::where('user_id', $user->id)->where('status', 'completed')->count();
        $certificates = Certificate::where('user_id', $user->id)->count();

        $watchSeconds = LessonProgress::where('user_id', $user->id)->sum('watch_time_seconds');
        $hours = (float) round($watchSeconds / 3600, 1);

        $avgCompletion = (int) round(Enrollment::where('user_id', $user->id)->avg('progress_percent') ?? 0);

        return [
            'purchased_courses' => $purchased,
            'in_progress_courses' => $inProgress,
            'completed_courses' => $completed,
            'certificates_earned' => $certificates,
            'learning_hours' => $hours,
            'learning_streak' => $inProgress > 0 ? 1 : 0,
            'overall_completion' => $avgCompletion,
        ];
    }

    public function getLastActiveCourse(User $user): ?array
    {
        $enrollment = Enrollment::with(['course.category', 'course.currentVersion.modules.lessons'])
            ->where('user_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->first();

        if ($enrollment && $enrollment->course) {
            $lastProgress = LessonProgress::where('user_id', $user->id)
                ->whereHas('lesson.module.courseVersion', function ($q) use ($enrollment) {
                    $q->where('course_id', $enrollment->course_id);
                })
                ->orderBy('updated_at', 'desc')
                ->first();

            $activeLesson = $lastProgress?->lesson;
            $activeModule = $activeLesson?->module;

            $cert = Certificate::where('user_id', $user->id)->first();
            $isCompleted = ($enrollment->progress_percent >= 100) || ($enrollment->status === 'completed');

            return [
                'course_id' => $enrollment->course->id,
                'title' => $enrollment->course->title,
                'category' => $enrollment->course->category?->name ?? 'Software Development',
                'progress_percent' => (int) ($enrollment->progress_percent ?? 0),
                'current_module' => $activeModule?->title ?? 'Module 1',
                'current_lesson' => $activeLesson?->title ?? 'Lesson 1',
                'active_lesson_id' => $activeLesson?->id,
                'remaining_mins' => $isCompleted ? 0 : max(5, (int) round(($enrollment->course->duration ?? 1800) / 60)),
                'is_completed' => $isCompleted,
                'certificate_id' => $cert?->id,
                'certificate_uuid' => $cert?->uuid,
            ];
        }

        return null;
    }

    public function getUpcomingClasses(User $user, int $limit = 3): Collection
    {
        if (\Illuminate\Support\Facades\Schema::hasTable('live_classes')) {
            return DB::table('live_classes')
                ->where('starts_at', '>=', now())
                ->orderBy('starts_at', 'asc')
                ->take($limit)
                ->get();
        }

        return collect([]);
    }

    public function getPendingAssignments(User $user, int $limit = 4): Collection
    {
        if (\Illuminate\Support\Facades\Schema::hasTable('assignments')) {
            return DB::table('assignments')
                ->take($limit)
                ->get();
        }

        return collect([]);
    }

    public function getUpcomingQuizzes(User $user, int $limit = 4): Collection
    {
        if (\Illuminate\Support\Facades\Schema::hasTable('quizzes')) {
            return DB::table('quizzes')
                ->take($limit)
                ->get();
        }

        return collect([]);
    }

    public function getRecentCertificates(User $user, int $limit = 3): Collection
    {
        return Certificate::with('course')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }

    public function getRecommendedCourses(User $user, int $limit = 3): Collection
    {
        $enrolledCourseIds = Enrollment::where('user_id', $user->id)->pluck('course_id');

        return Course::with(['category', 'currentVersion'])
            ->whereNotIn('id', $enrolledCourseIds)
            ->take($limit)
            ->get();
    }

    public function getRecommendedJobs(User $user, int $limit = 3): Collection
    {
        return JobPosting::with('company')->take($limit)->get();
    }

    public function getCareerProgress(User $user): array
    {
        $profile = $user->profile;

        return [
            'profile_completion' => $profile?->profile_completion_percentage ?? 0,
            'ats_score' => $profile?->profile_completion_percentage ?? 0,
            'jobs_applied' => 0,
            'interviews_scheduled' => 0,
            'top_skill_gaps' => [],
        ];
    }

    public function getCalendarEvents(User $user): Collection
    {
        return collect([]);
    }

    public function getNotifications(User $user, int $limit = 5): Collection
    {
        return collect([]);
    }

    public function getAIInsights(User $user): array
    {
        $enrolledCount = Enrollment::where('user_id', $user->id)->count();

        if ($enrolledCount > 0) {
            return [
                'headline' => 'Active Learning Milestone',
                'insight' => 'Keep watching your course modules to earn your verified course completion certificate.',
                'recommended_action' => 'Continue Learning',
            ];
        }

        return [
            'headline' => 'Start Your Learning Journey',
            'insight' => 'Browse our real course catalog to enroll and start building enterprise software skills.',
            'recommended_action' => 'Browse Courses',
        ];
    }
}
