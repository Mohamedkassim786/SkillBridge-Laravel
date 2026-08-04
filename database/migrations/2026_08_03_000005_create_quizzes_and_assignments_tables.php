<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('module_id')->constrained('modules')->onDelete('cascade');
            $table->string('title');
            $table->unsignedTinyInteger('pass_percentage')->default(80);
            $table->timestamps();
        });

        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('quiz_id')->constrained('quizzes')->onDelete('cascade');
            $table->text('question_text');
            $table->unsignedInteger('points')->default(1);
            $table->timestamps();
        });

        Schema::create('quiz_options', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('question_id')->constrained('quiz_questions')->onDelete('cascade');
            $table->text('option_text');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });

        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('quiz_id')->constrained('quizzes')->onDelete('cascade');
            $table->foreignUlid('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedTinyInteger('score_percentage');
            $table->boolean('is_passed');
            $table->json('attempt_snapshot')->comment('Immutable JSON snapshot of question options and student selections');
            $table->timestamps();
        });

        Schema::create('assignments', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('course_version_id')->constrained('course_versions')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->timestamp('due_date')->nullable();
            $table->unsignedInteger('max_score')->default(100);
            $table->timestamps();
        });

        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->foreignUlid('user_id')->constrained('users')->onDelete('cascade');
            $table->string('submission_file_path');
            $table->unsignedInteger('score')->nullable();
            $table->text('feedback')->nullable();
            $table->enum('status', ['submitted', 'graded', 'resubmit_required'])->default('submitted');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assignment_submissions');
        Schema::dropIfExists('assignments');
        Schema::dropIfExists('quiz_attempts');
        Schema::dropIfExists('quiz_options');
        Schema::dropIfExists('quiz_questions');
        Schema::dropIfExists('quizzes');
    }
};
