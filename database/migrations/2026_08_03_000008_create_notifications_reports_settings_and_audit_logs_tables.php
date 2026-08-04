<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_providers', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name')->unique()->comment('openai, gemini, anthropic');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('ai_models', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('provider_id')->constrained('ai_providers')->onDelete('cascade');
            $table->string('model_code')->unique()->comment('gpt-4o, gemini-1.5-flash, claude-3-5-sonnet');
            $table->decimal('cost_per_1k_input_tokens', 8, 6)->default(0.000000);
            $table->decimal('cost_per_1k_output_tokens', 8, 6)->default(0.000000);
            $table->timestamps();
        });

        Schema::create('ai_token_usages', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignUlid('model_id')->constrained('ai_models')->onDelete('cascade');
            $table->string('feature_context')->comment('resume_ats, mock_interview, career_recommendation');
            $table->unsignedInteger('input_tokens')->default(0);
            $table->unsignedInteger('output_tokens')->default(0);
            $table->decimal('calculated_cost_usd', 10, 6)->default(0.000000);
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
        });

        Schema::create('ai_analysis_reports', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('application_id')->constrained('job_applications')->onDelete('cascade');
            $table->unsignedTinyInteger('ats_score');
            $table->json('keyword_matches');
            $table->json('missing_skills');
            $table->json('recommended_course_ids');
            $table->timestamps();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->string('notifiable_type');
            $table->ulid('notifiable_id');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        Schema::create('user_notification_settings', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')->constrained('users')->onDelete('cascade');
            $table->boolean('email_course_updates')->default(true);
            $table->boolean('email_job_alerts')->default(true);
            $table->boolean('push_application_updates')->default(true);
            $table->timestamps();
        });

        Schema::create('placement_reports', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->unsignedSmallInteger('period_year');
            $table->unsignedTinyInteger('period_month');
            $table->unsignedInteger('total_applications')->default(0);
            $table->unsignedInteger('total_hired')->default(0);
            $table->decimal('placement_rate_percent', 5, 2)->default(0.00);
            $table->timestamps();
        });

        Schema::create('revenue_reports', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->unsignedSmallInteger('period_year');
            $table->unsignedTinyInteger('period_month');
            $table->decimal('gross_revenue', 12, 2)->default(0.00);
            $table->decimal('trainer_payouts', 12, 2)->default(0.00);
            $table->decimal('net_platform_revenue', 12, 2)->default(0.00);
            $table->timestamps();
        });

        Schema::create('system_settings', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('action');
            $table->string('ip_address', 45);
            $table->text('user_agent')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('user_id');
            $table->index('action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('system_settings');
        Schema::dropIfExists('revenue_reports');
        Schema::dropIfExists('placement_reports');
        Schema::dropIfExists('user_notification_settings');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('ai_analysis_reports');
        Schema::dropIfExists('ai_token_usages');
        Schema::dropIfExists('ai_models');
        Schema::dropIfExists('ai_providers');
    }
};
