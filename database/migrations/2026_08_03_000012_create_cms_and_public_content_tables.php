<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cms_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->default('general');
            $table->timestamps();
        });

        Schema::create('pricing_plans', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('title');
            $table->string('slug')->unique();
            $table->decimal('monthly_price', 10, 2)->default(0.00);
            $table->decimal('yearly_price', 10, 2)->default(0.00);
            $table->string('badge')->nullable();
            $table->json('features')->nullable();
            $table->string('cta_text')->default('Get Started');
            $table->boolean('is_popular')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('success_stories', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('student_name');
            $table->string('photo_url')->nullable();
            $table->string('company_name');
            $table->string('company_logo')->nullable();
            $table->string('job_title');
            $table->string('salary_package')->nullable(); // e.g. 18 LPA / $120,000
            $table->string('course_title')->nullable();
            $table->text('testimonial');
            $table->string('linkedin_url')->nullable();
            $table->boolean('is_featured')->default(true);
            $table->timestamps();
        });

        Schema::create('blog_posts', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('cover_image')->nullable();
            $table->string('category')->default('Software Architecture');
            $table->string('author_name')->default('SkillBridge Editorial');
            $table->integer('read_time_mins')->default(5);
            $table->integer('views_count')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('public_events', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('event_type')->default('Webinar'); // Webinar, Live Class, Workshop
            $table->string('instructor_name')->default('Dr. Marcus Vance');
            $table->string('instructor_avatar')->nullable();
            $table->timestamp('starts_at');
            $table->integer('duration_mins')->default(60);
            $table->string('meeting_url')->default('https://meet.google.com/skillbridge-live');
            $table->string('cover_image')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_upcoming')->default(true);
            $table->timestamps();
        });

        Schema::create('faqs', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('question');
            $table->text('answer');
            $table->string('category')->default('General'); // Courses, Pricing, Certificates, Placements
            $table->integer('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('contact_messages', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject');
            $table->text('message');
            $table->enum('status', ['unread', 'read', 'replied'])->default('unread');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('public_events');
        Schema::dropIfExists('blog_posts');
        Schema::dropIfExists('success_stories');
        Schema::dropIfExists('pricing_plans');
        Schema::dropIfExists('cms_settings');
    }
};
