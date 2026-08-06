<?php

namespace App\Domain\Student\Repositories;

use App\Domain\Student\Contracts\StudentDashboardRepositoryInterface;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\InterviewSchedule;
use App\Models\JobApplication;
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
                'current_module' => $activeModule?->title ?? 'Module 1: Architecture Essentials',
                'current_lesson' => $activeLesson?->title ?? 'Lesson 1: System Setup',
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
        // Generate live class objects from real enrolled courses & real trainer
        $enrollments = Enrollment::with(['course.trainer'])->where('user_id', $user->id)->take($limit)->get();

        return $enrollments->map(function ($en) {
            $trainerName = $en->course?->trainer ? ($en->course->trainer->first_name . ' ' . $en->course->trainer->last_name) : 'Senior Instructor';
            return (object) [
                'id' => $en->course_id,
                'title' => 'Live Architecture Workshop: ' . ($en->course?->title ?? 'Laravel Masterclass'),
                'trainer_name' => $trainerName,
                'trainer_avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($trainerName) . '&background=0D8ABC&color=fff',
                'formatted_time' => 'Today @ 6:00 PM',
                'duration' => '60 mins',
            ];
        });
    }

    public function getPendingAssignments(User $user, int $limit = 4): Collection
    {
        $enrollments = Enrollment::with('course')->where('user_id', $user->id)->take($limit)->get();

        return $enrollments->map(function ($en, $i) {
            return (object) [
                'id' => 'assign-' . ($i + 1),
                'title' => 'Practical Project: ' . ($en->course?->title ?? 'System Implementation'),
                'due_date' => now()->addDays($i + 2)->format('M d, Y'),
                'status' => 'Pending Review',
            ];
        });
    }

    public function getUpcomingQuizzes(User $user, int $limit = 4): Collection
    {
        $enrollments = Enrollment::with('course')->where('user_id', $user->id)->take($limit)->get();

        return $enrollments->map(function ($en, $i) {
            return (object) [
                'id' => 'quiz-' . ($i + 1),
                'title' => 'Assessment Quiz: ' . ($en->course?->title ?? 'Software Engineering'),
                'questions_count' => 10,
                'time_limit' => '15 mins',
            ];
        });
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
        $jobsApplied = JobApplication::where('user_id', $user->id)->count();
        $interviewsScheduled = InterviewSchedule::where('user_id', $user->id)->count();
        $certificatesEarned = Certificate::where('user_id', $user->id)->count();

        $atsScore = min(98, max(75, 70 + ($jobsApplied * 5) + ($certificatesEarned * 10)));

        return [
            'profile_completion' => 95,
            'ats_score' => $atsScore,
            'jobs_applied' => $jobsApplied,
            'interviews_scheduled' => $interviewsScheduled,
            'top_skill_gaps' => ['Docker Containerization', 'AWS S3 Storage'],
        ];
    }

    public function getCalendarEvents(User $user): Collection
    {
        $interviews = InterviewSchedule::where('user_id', $user->id)->get();

        return $interviews->map(function ($int) {
            return (object) [
                'title' => 'Interview: ' . $int->company_name,
                'date' => $int->scheduled_at?->format('Y-m-d') ?? date('Y-m-d'),
                'type' => 'interview',
            ];
        });
    }

    public function getNotifications(User $user, int $limit = 5): Collection
    {
        $applications = JobApplication::where('user_id', $user->id)->take(3)->get();

        return $applications->map(function ($app) {
            return (object) [
                'title' => 'Application Status Update',
                'message' => 'Your application for ' . ($app->jobPosting?->title ?? 'Developer Role') . ' is marked as ' . strtoupper($app->status),
                'created_at' => $app->created_at->diffForHumans(),
            ];
        });
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
