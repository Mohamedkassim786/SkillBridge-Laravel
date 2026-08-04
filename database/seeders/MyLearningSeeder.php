<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\CourseResource;
use App\Models\CourseReview;
use App\Models\CourseVersion;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonBookmark;
use App\Models\LessonNote;
use App\Models\LessonProgress;
use App\Models\Module;
use App\Models\User;
use Illuminate\Database\Seeder;

class MyLearningSeeder extends Seeder
{
    public function run(): void
    {
        $student = User::where('email', 'student@skillbridge.com')->first();
        $trainer = User::where('email', 'staff@skillbridge.com')->first();

        if (! $student || ! $trainer) {
            return;
        }

        // 1. Categories
        $catWeb = Category::firstOrCreate(['slug' => 'web-development'], ['name' => 'Web Development']);
        $catDevOps = Category::firstOrCreate(['slug' => 'cloud-devops'], ['name' => 'Cloud & DevOps']);

        // 2. Course 1: Full-Stack Architecture
        $course1 = Course::firstOrCreate(
            ['slug' => 'full-stack-laravel-architecture'],
            [
                'title' => 'Full-Stack Software Architecture with Laravel 12 & Livewire 3',
                'category_id' => $catWeb->id,
                'trainer_id' => $trainer->id,
            ]
        );

        $v1 = CourseVersion::firstOrCreate(
            ['course_id' => $course1->id, 'version_code' => 'v1.0'],
            [
                'price' => 99.00,
                'level' => 'advanced',
                'description' => 'Enterprise Laravel 12 application design focusing on Repository Pattern, Service Layer, and Livewire 3.',
                'is_published' => true,
            ]
        );
        $course1->update(['current_version_id' => $v1->id]);

        $m1 = Module::firstOrCreate(
            ['course_version_id' => $v1->id, 'sort_order' => 1],
            ['title' => 'Module 1: Domain Architecture & SOLID Principles']
        );

        $m2 = Module::firstOrCreate(
            ['course_version_id' => $v1->id, 'sort_order' => 2],
            ['title' => 'Module 2: Repositories & Service Layer Integration']
        );

        $l1 = Lesson::firstOrCreate(
            ['module_id' => $m1->id, 'sort_order' => 1],
            [
                'title' => 'Lesson 1: Introduction to Domain Driven Architecture',
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'duration' => 1200,
                'is_free_preview' => true,
            ]
        );

        $l2 = Lesson::firstOrCreate(
            ['module_id' => $m2->id, 'sort_order' => 1],
            [
                'title' => 'Lesson 2: Building Enterprise Repositories in PHP 8.3',
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'duration' => 1800,
                'is_free_preview' => false,
            ]
        );

        // Enroll Student
        Enrollment::firstOrCreate(
            ['user_id' => $student->id, 'course_id' => $course1->id],
            [
                'course_version_id' => $v1->id,
                'progress_percent' => 65,
                'status' => 'active',
            ]
        );

        LessonProgress::firstOrCreate(
            ['user_id' => $student->id, 'lesson_id' => $l1->id],
            [
                'watch_time_seconds' => 1200,
                'watch_percentage' => 100,
                'is_completed' => true,
            ]
        );

        LessonNote::firstOrCreate(
            ['user_id' => $student->id, 'lesson_id' => $l1->id, 'timestamp_seconds' => 255],
            ['note_text' => 'Domain Driven Design separates domain logic from Laravel framework controllers!']
        );

        LessonBookmark::firstOrCreate(
            ['user_id' => $student->id, 'lesson_id' => $l1->id, 'timestamp_seconds' => 540],
            ['title' => 'Key Architecture Diagram Explanation']
        );

        CourseResource::firstOrCreate(
            ['course_id' => $course1->id, 'title' => 'Domain-Architecture-Blueprint.pdf'],
            [
                'file_path' => 'resources/architecture.pdf',
                'file_size' => '2.4 MB',
                'version' => 'v1.2',
            ]
        );

        // 3. Course 2: Redis & Cloud Queues
        $course2 = Course::firstOrCreate(
            ['slug' => 'redis-caching-and-queues'],
            [
                'title' => 'Mastering Redis Caching & Queue Processing in Laravel',
                'category_id' => $catDevOps->id,
                'trainer_id' => $trainer->id,
            ]
        );

        $v2 = CourseVersion::firstOrCreate(
            ['course_id' => $course2->id, 'version_code' => 'v1.0'],
            [
                'price' => 49.00,
                'level' => 'intermediate',
                'description' => 'High-throughput queue management with Horizon, Redis buffers, and atomic cache locks.',
                'is_published' => true,
            ]
        );
        $course2->update(['current_version_id' => $v2->id]);

        Enrollment::firstOrCreate(
            ['user_id' => $student->id, 'course_id' => $course2->id],
            [
                'course_version_id' => $v2->id,
                'progress_percent' => 10,
                'status' => 'active',
            ]
        );
    }
}
