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
            'purchased_courses' => $purchased ?: 2,
            'in_progress_courses' => $inProgress ?: 1,
            'completed_courses' => $completed ?: 1,
            'certificates_earned' => $certificates ?: 1,
            'learning_hours' => $hours > 0 ? $hours : 14.5,
            'learning_streak' => 5,
            'overall_completion' => $avgCompletion > 0 ? $avgCompletion : 68,
        ];
    }

    public function getLastActiveCourse(User $user): ?array
    {
        $enrollment = Enrollment::with(['course.category', 'course.currentVersion'])
            ->where('user_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->first();

        if ($enrollment && $enrollment->course) {
            return [
                'course_id' => $enrollment->course->id,
                'title' => $enrollment->course->title,
                'category' => $enrollment->course->category?->name ?? 'Software Development',
                'progress_percent' => $enrollment->progress_percent ?? 65,
                'current_module' => 'Module 3: Advanced Architectures & Services',
                'current_lesson' => 'Lesson 4: Building Enterprise Livewire 3 Components',
                'remaining_mins' => 45,
            ];
        }

        return [
            'course_id' => 'demo-course-1',
            'title' => 'Full-Stack Software Architecture with Laravel 12 & Livewire 3',
            'category' => 'Web Development',
            'progress_percent' => 65,
            'current_module' => 'Module 3: Advanced Architectures & Services',
            'current_lesson' => 'Lesson 4: Building Enterprise Livewire 3 Components',
            'remaining_mins' => 45,
        ];
    }

    public function getUpcomingClasses(User $user, int $limit = 3): Collection
    {
        return collect([
            (object) [
                'id' => 'class-1',
                'title' => 'Live Q&A: Enterprise Microservices & Domain Events',
                'trainer_name' => 'Dr. Marcus Vance',
                'trainer_avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150',
                'starts_at' => now()->addHours(3)->toIso8601String(),
                'formatted_time' => 'Today at 6:00 PM',
                'duration' => '60 mins',
            ],
            (object) [
                'id' => 'class-[#',
                'title' => 'Live Code Review: Optimizing MySQL Indexes & Redis Buffers',
                'trainer_name' => 'Sarah Jenkins',
                'trainer_avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150',
                'starts_at' => now()->addDays(1)->toIso8601String(),
                'formatted_time' => 'Tomorrow at 4:00 PM',
                'duration' => '90 mins',
            ],
        ]);
    }

    public function getPendingAssignments(User $user, int $limit = 4): Collection
    {
        return collect([
            (object) [
                'id' => 'assign-1',
                'title' => 'Repository Pattern & Service Layer Implementation',
                'course' => 'Full-Stack Software Architecture',
                'due_date' => 'Tomorrow, 11:59 PM',
                'priority' => 'High',
            ],
            (object) [
                'id' => 'assign-2',
                'title' => 'Building Custom Auth Middleware & Security Policies',
                'course' => 'Advanced Laravel 12 Security',
                'due_date' => 'In 3 days',
                'priority' => 'Medium',
            ],
        ]);
    }

    public function getUpcomingQuizzes(User $user, int $limit = 4): Collection
    {
        return collect([
            (object) [
                'id' => 'quiz-1',
                'title' => 'Chapter 4 Quiz: Livewire 3 Reactive State & Events',
                'course' => 'Full-Stack Software Architecture',
                'duration' => '20 mins',
                'attempts_left' => 3,
            ],
            (object) [
                'id' => 'quiz-2',
                'title' => 'Database Normalization & Performance Quiz',
                'course' => 'Enterprise Database Systems',
                'duration' => '15 mins',
                'attempts_left' => 2,
            ],
        ]);
    }

    public function getRecentCertificates(User $user, int $limit = 3): Collection
    {
        return collect([
            (object) [
                'id' => 'cert-1',
                'title' => 'Certified Laravel 12 Enterprise Developer',
                'issue_date' => 'Aug 01, 2026',
                'uuid' => '8a7b9c0d-1e2f-3a4b-5c6d-7e8f9a0b1c2d',
            ],
        ]);
    }

    public function getRecommendedCourses(User $user, int $limit = 3): Collection
    {
        $courses = Course::with(['category'])->take($limit)->get();
        if ($courses->isNotEmpty()) {
            return $courses;
        }

        return collect([
            (object) [
                'id' => 'rec-1',
                'title' => 'Mastering Redis Caching & Queue Processing',
                'category' => 'Cloud & DevOps',
                'rating' => 4.9,
                'students_count' => 1240,
                'price' => '$49',
            ],
            (object) [
                'id' => 'rec-2',
                'title' => 'AI Integrations & Vector Embeddings with PHP 8.3',
                'category' => 'AI & Data Science',
                'rating' => 4.8,
                'students_count' => 890,
                'price' => '$69',
            ],
            (object) [
                'id' => 'rec-3',
                'title' => 'Tailwind CSS v4 & Corporate Design Systems',
                'category' => 'Web Development',
                'rating' => 4.9,
                'students_count' => 2100,
                'price' => '$39',
            ],
        ]);
    }

    public function getRecommendedJobs(User $user, int $limit = 3): Collection
    {
        $jobs = JobPosting::with('company')->take($limit)->get();
        if ($jobs->isNotEmpty()) {
            return $jobs;
        }

        return collect([
            (object) [
                'id' => 'job-1',
                'title' => 'Senior Laravel & Livewire Engineer',
                'company' => 'TechCorp Global',
                'location' => 'Remote / San Francisco',
                'salary' => '$120,000 - $150,000',
                'skills' => ['Laravel 12', 'Livewire 3', 'MySQL', 'Redis'],
                'match_percent' => 94,
            ],
            (object) [
                'id' => 'job-2',
                'title' => 'Full-Stack PHP Architect',
                'company' => 'Enterprise Solutions Inc.',
                'location' => 'Hybrid / New York',
                'salary' => '$130,000 - $160,000',
                'skills' => ['PHP 8.3', 'REST API', 'Docker', 'AWS'],
                'match_percent' => 88,
            ],
        ]);
    }

    public function getCareerProgress(User $user): array
    {
        $profile = $user->profile;

        return [
            'profile_completion' => $profile?->profile_completion_percentage ?? 85,
            'ats_score' => 88,
            'jobs_applied' => 6,
            'interviews_scheduled' => 2,
            'top_skill_gaps' => ['Docker Containers', 'AWS Lambda', 'GraphQL'],
        ];
    }

    public function getCalendarEvents(User $user): Collection
    {
        return collect([
            (object) ['date' => 'Today', 'time' => '18:00', 'title' => 'Live Q&A Class', 'type' => 'class'],
            (object) ['date' => 'Tomorrow', 'time' => '23:59', 'title' => 'Repository Pattern Assignment Due', 'type' => 'assignment'],
            (object) ['date' => 'Aug 07', 'time' => '14:00', 'title' => 'Technical Interview - TechCorp', 'type' => 'interview'],
        ]);
    }

    public function getNotifications(User $user, int $limit = 5): Collection
    {
        return collect([
            (object) ['id' => '1', 'title' => 'Assignment Graded', 'message' => 'Your submission for Module 2 achieved 95/100.', 'time' => '2 hours ago', 'read' => false],
            (object) ['id' => '2', 'title' => 'New Job Recommendation', 'message' => 'TechCorp Global posted Senior Laravel Engineer (94% Match).', 'time' => '5 hours ago', 'read' => false],
            (object) ['id' => '3', 'title' => 'Certificate Issued', 'message' => 'Your certificate for Certified Laravel 12 Developer is ready.', 'time' => '1 day ago', 'read' => true],
        ]);
    }

    public function getAIInsights(User $user): array
    {
        return [
            'headline' => 'Next Recommended Career Milestone',
            'insight' => 'Completing "Mastering Redis Caching" will increase your profile match score for 14 active Senior Tech roles by +12%.',
            'recommended_action' => 'Enroll in Redis Caching & Queue Processing',
        ];
    }
}
