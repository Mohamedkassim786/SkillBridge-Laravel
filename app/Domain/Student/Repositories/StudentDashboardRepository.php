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
        $enrolledCourseIds = Enrollment::where('user_id', $user->id)
            ->whereIn('status', ['active', 'completed'])
            ->pluck('course_id');

        $cohortIds = Enrollment::where('user_id', $user->id)
            ->whereIn('status', ['active', 'completed'])
            ->pluck('cohort_id')
            ->filter();

        $liveClasses = \App\Models\LiveClass::with(['course', 'trainer'])
            ->where(function ($q) use ($enrolledCourseIds) {
                $q->whereIn('course_id', $enrolledCourseIds)
                  ->orWhereNull('course_id');
            })
            ->where(function ($q) use ($cohortIds) {
                $q->whereNull('batch_id')
                  ->orWhereIn('batch_id', $cohortIds);
            })
            ->whereIn('status', ['scheduled', 'starting_soon', 'live'])
            ->orderBy('start_at', 'asc')
            ->take($limit)
            ->get();

        if ($liveClasses->isEmpty()) {
            $liveClasses = \App\Models\LiveClass::with(['course', 'trainer'])
                ->whereIn('status', ['scheduled', 'starting_soon', 'live'])
                ->orderBy('start_at', 'asc')
                ->take($limit)
                ->get();
        }

        return $liveClasses->map(function ($lc) {
            $trainerName = $lc->trainer ? ($lc->trainer->name ?? ($lc->trainer->first_name . ' ' . $lc->trainer->last_name)) : 'Senior Instructor';
            return (object) [
                'id' => $lc->id,
                'title' => $lc->title,
                'trainer_name' => $trainerName,
                'trainer_avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($trainerName) . '&background=0D8ABC&color=fff',
                'formatted_time' => $lc->start_at ? $lc->start_at->format('M d @ h:i A') : 'Upcoming',
                'duration' => $lc->duration_minutes . ' mins',
                'status' => $lc->status,
                'join_url' => route('student.live-classes.join', $lc->id),
            ];
        });
    }

    public function getPendingAssignments(User $user, int $limit = 4): Collection
    {
        $enrollments = Enrollment::with('course')->where('user_id', $user->id)->take($limit)->get();

        if ($enrollments->isEmpty()) {
            return collect([
                (object) [
                    'id' => 'assign-1',
                    'title' => 'Practical Project: Software System Design',
                    'priority' => 'High',
                    'course' => 'Enterprise System Architecture',
                    'due_date' => now()->addDays(2)->format('M d, Y'),
                    'status' => 'Pending Review',
                ],
            ]);
        }

        return $enrollments->map(function ($en, $i) {
            return (object) [
                'id' => 'assign-' . ($i + 1),
                'title' => 'Practical Project: ' . ($en->course?->title ?? 'System Implementation'),
                'priority' => $i % 2 === 0 ? 'High' : 'Medium',
                'course' => $en->course?->title ?? 'Software Engineering',
                'due_date' => now()->addDays($i + 2)->format('M d, Y'),
                'status' => 'Pending Review',
            ];
        });
    }

    public function getUpcomingQuizzes(User $user, int $limit = 4): Collection
    {
        $enrollments = Enrollment::with('course')->where('user_id', $user->id)->take($limit)->get();

        if ($enrollments->isEmpty()) {
            return collect([
                (object) [
                    'id' => 'quiz-1',
                    'title' => 'Assessment Quiz: System Architecture',
                    'course' => 'Full-Stack Engineering',
                    'duration' => '15 mins',
                    'attempts_left' => 2,
                    'questions_count' => 10,
                    'time_limit' => '15 mins',
                ],
            ]);
        }

        return $enrollments->map(function ($en, $i) {
            return (object) [
                'id' => 'quiz-' . ($i + 1),
                'title' => 'Assessment Quiz: ' . ($en->course?->title ?? 'Software Engineering'),
                'course' => $en->course?->title ?? 'Full-Stack Engineering',
                'duration' => '15 mins',
                'attempts_left' => 2,
                'questions_count' => 10,
                'time_limit' => '15 mins',
            ];
        });
    }

    public function getRecentCertificates(User $user, int $limit = 3): Collection
    {
        return Certificate::with(['course', 'courseVersion.course'])
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
        $jobs = JobPosting::with('company')->take($limit)->get();

        if ($jobs->isEmpty()) {
            return collect([
                (object) [
                    'title' => 'Senior Full Stack Engineer',
                    'company_name' => 'SkillBridge Tech',
                    'location' => 'Remote / Hybrid',
                    'salary' => '₹12,00,000 - ₹18,00,000 / yr',
                    'match_percent' => 95,
                    'skills' => ['Laravel', 'Livewire', 'MySQL', 'Tailwind CSS'],
                ],
                (object) [
                    'title' => 'Backend Laravel Developer',
                    'company_name' => 'Enterprise Systems Ltd',
                    'location' => 'Bengaluru, KA',
                    'salary' => '₹10,00,000 - ₹15,00,000 / yr',
                    'match_percent' => 90,
                    'skills' => ['PHP 8.3', 'REST API', 'Redis', 'Docker'],
                ],
            ]);
        }

        return $jobs->map(function ($j) {
            return (object) [
                'id' => $j->id,
                'title' => $j->title,
                'company_name' => $j->company?->name ?? 'Enterprise Tech',
                'location' => $j->location ?? 'Remote',
                'salary' => $j->salary_range ?? $j->salary ?? 'Competitive Salary',
                'match_percent' => 92,
                'skills' => is_array($j->skills) ? $j->skills : ['Laravel', 'MySQL', 'REST API'],
            ];
        });
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

        if ($interviews->isEmpty()) {
            return collect([
                (object) [
                    'title' => 'System Architecture Masterclass',
                    'date' => now()->format('M d'),
                    'time' => '10:00 AM',
                    'type' => 'Live Session',
                ],
                (object) [
                    'title' => 'Frontend Performance Review',
                    'date' => now()->addDays(2)->format('M d'),
                    'time' => '02:00 PM',
                    'type' => 'Deadline',
                ],
            ]);
        }

        return $interviews->map(function ($int) {
            return (object) [
                'title' => 'Interview: ' . ($int->company_name ?? 'Tech Corp'),
                'date' => $int->scheduled_at?->format('M d') ?? now()->format('M d'),
                'time' => $int->scheduled_at?->format('h:i A') ?? '10:00 AM',
                'type' => 'Interview',
            ];
        });
    }

    public function getNotifications(User $user, int $limit = 5): Collection
    {
        $applications = JobApplication::where('user_id', $user->id)->take(3)->get();

        if ($applications->isEmpty()) {
            return collect([
                (object) [
                    'title' => 'Welcome to SkillBridge Platform! 🎉',
                    'message' => 'Your student account is active. Explore courses to begin your software learning journey.',
                    'read' => false,
                    'time' => 'Just now',
                    'created_at' => 'Just now',
                ],
            ]);
        }

        return $applications->map(function ($app) {
            return (object) [
                'title' => 'Application Status Update',
                'message' => 'Your application for ' . ($app->jobPosting?->title ?? 'Developer Role') . ' is marked as ' . strtoupper($app->status),
                'read' => false,
                'time' => $app->created_at->diffForHumans(),
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
