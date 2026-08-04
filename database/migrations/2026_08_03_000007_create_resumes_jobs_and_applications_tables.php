<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_resumes', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->string('file_path');
            $table->text('parsed_text')->nullable();
            $table->json('parsed_skills')->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        Schema::create('job_categories', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('job_postings', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('company_id')->nullable()->constrained('companies')->onDelete('cascade');
            $table->foreignUlid('category_id')->nullable()->constrained('job_categories')->onDelete('set null');
            $table->string('deduplication_hash', 32)->nullable()->unique()->comment('MD5(company + title + location) for external job deduplication');
            $table->enum('source', ['internal', 'adzuna', 'remoteok', 'arbeitnow', 'greenhouse'])->default('internal');
            $table->string('external_id')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->longText('description');
            $table->string('location');
            $table->decimal('salary_min', 12, 2)->nullable();
            $table->decimal('salary_max', 12, 2)->nullable();
            $table->enum('status', ['draft', 'active', 'closed'])->default('active');
            $table->timestamps();

            $table->index('source');
            $table->index('status');
            $table->index('deduplication_hash');
        });

        Schema::create('job_applications', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('job_posting_id')->constrained('job_postings')->onDelete('cascade');
            $table->foreignUlid('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignUlid('resume_id')->constrained('user_resumes')->onDelete('restrict');
            $table->unsignedTinyInteger('ai_ats_score')->nullable();
            $table->enum('status', ['submitted', 'under_review', 'shortlisted', 'interview_scheduled', 'hired', 'rejected'])->default('submitted');
            $table->timestamps();

            $table->unique(['job_posting_id', 'user_id']);
        });

        Schema::create('application_status_histories', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('application_id')->constrained('job_applications')->onDelete('cascade');
            $table->foreignUlid('changed_by_user_id')->constrained('users')->onDelete('restrict');
            $table->string('previous_status', 50);
            $table->string('new_status', 50);
            $table->text('comment')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('application_status_histories');
        Schema::dropIfExists('job_applications');
        Schema::dropIfExists('job_postings');
        Schema::dropIfExists('job_categories');
        Schema::dropIfExists('user_resumes');
    }
};
