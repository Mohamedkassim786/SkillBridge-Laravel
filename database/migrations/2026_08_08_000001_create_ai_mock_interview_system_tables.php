<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mock_interviews', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignUlid('job_id')->nullable()->constrained('job_postings')->onDelete('set null');
            $table->foreignUlid('resume_id')->nullable()->constrained('user_resumes')->onDelete('set null');
            $table->string('interview_type')->default('technical'); // hr, technical, resume, job_specific, full_mock
            $table->string('role');
            $table->string('technology')->nullable();
            $table->unsignedTinyInteger('difficulty')->default(3);
            $table->string('mode')->default('real'); // real, practice, beginner
            $table->string('voice')->default('Magpie-Multilingual.EN-US.Aria');
            $table->integer('duration')->default(0); // seconds
            $table->string('status')->default('created'); // created, in_progress, paused, completed, cancelled
            $table->unsignedTinyInteger('overall_score')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index('student_id');
            $table->index('interview_type');
            $table->index('status');
        });

        Schema::create('interview_questions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('mock_interview_id')->constrained('mock_interviews')->onDelete('cascade');
            $table->text('question');
            $table->string('question_type')->default('technical'); // hr, technical, behavioral, situational, resume, followup
            $table->string('topic')->nullable();
            $table->unsignedTinyInteger('difficulty')->default(3);
            $table->unsignedInteger('sequence')->default(1);
            $table->json('ai_metadata')->nullable();
            $table->timestamp('asked_at')->nullable();
            $table->timestamps();

            $table->index('mock_interview_id');
        });

        Schema::create('interview_responses', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('interview_question_id')->constrained('interview_questions')->onDelete('cascade');
            $table->string('audio_path')->nullable();
            $table->longText('transcript');
            $table->integer('duration')->nullable(); // seconds
            $table->unsignedInteger('word_count')->nullable();
            $table->unsignedInteger('words_per_minute')->nullable();
            $table->unsignedInteger('pause_count')->nullable();
            $table->unsignedInteger('filler_word_count')->nullable();
            $table->timestamps();

            $table->index('interview_question_id');
        });

        Schema::create('interview_evaluations', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('response_id')->constrained('interview_responses')->onDelete('cascade');
            $table->unsignedTinyInteger('technical_score')->nullable();
            $table->unsignedTinyInteger('communication_score')->nullable();
            $table->unsignedTinyInteger('clarity_score')->nullable();
            $table->unsignedTinyInteger('confidence_score')->nullable();
            $table->unsignedTinyInteger('relevance_score')->nullable();
            $table->unsignedTinyInteger('structure_score')->nullable();
            $table->unsignedTinyInteger('grammar_score')->nullable();
            $table->unsignedTinyInteger('professionalism_score')->nullable();
            $table->text('feedback')->nullable();
            $table->text('improved_answer')->nullable();
            $table->json('strengths')->nullable();
            $table->json('weaknesses')->nullable();
            $table->timestamps();

            $table->index('response_id');
        });

        Schema::create('interview_reports', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('mock_interview_id')->constrained('mock_interviews')->onDelete('cascade');
            $table->unsignedTinyInteger('overall_score');
            $table->unsignedTinyInteger('technical_score')->nullable();
            $table->unsignedTinyInteger('communication_score')->nullable();
            $table->unsignedTinyInteger('clarity_score')->nullable();
            $table->unsignedTinyInteger('confidence_score')->nullable();
            $table->unsignedTinyInteger('relevance_score')->nullable();
            $table->unsignedTinyInteger('structure_score')->nullable();
            $table->unsignedTinyInteger('grammar_score')->nullable();
            $table->unsignedTinyInteger('professionalism_score')->nullable();
            $table->json('strengths')->nullable();
            $table->json('weaknesses')->nullable();
            $table->json('improvement_plan')->nullable();
            $table->json('recommended_topics')->nullable();
            $table->text('final_feedback')->nullable();
            $table->timestamps();

            $table->index('mock_interview_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interview_reports');
        Schema::dropIfExists('interview_evaluations');
        Schema::dropIfExists('interview_responses');
        Schema::dropIfExists('interview_questions');
        Schema::dropIfExists('mock_interviews');
    }
};
