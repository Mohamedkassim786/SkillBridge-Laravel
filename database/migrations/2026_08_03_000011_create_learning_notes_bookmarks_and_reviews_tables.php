<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lesson_notes', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignUlid('lesson_id')->constrained('lessons')->onDelete('cascade');
            $table->unsignedInteger('timestamp_seconds')->default(0);
            $table->text('note_text');
            $table->timestamps();

            $table->index(['user_id', 'lesson_id']);
        });

        Schema::create('lesson_bookmarks', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignUlid('lesson_id')->constrained('lessons')->onDelete('cascade');
            $table->unsignedInteger('timestamp_seconds')->default(0);
            $table->string('title')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'lesson_id']);
        });

        Schema::create('course_resources', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignUlid('lesson_id')->nullable()->constrained('lessons')->onDelete('cascade');
            $table->string('title');
            $table->string('file_path');
            $table->string('file_size', 50)->default('1.2 MB');
            $table->string('version', 20)->default('v1.0');
            $table->unsignedInteger('download_count')->default(0);
            $table->timestamps();
        });

        Schema::create('course_reviews', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignUlid('course_id')->constrained('courses')->onDelete('cascade');
            $table->unsignedTinyInteger('rating')->default(5);
            $table->text('review_text')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'course_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_reviews');
        Schema::dropIfExists('course_resources');
        Schema::dropIfExists('lesson_bookmarks');
        Schema::dropIfExists('lesson_notes');
    }
};
