<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media_assets', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->enum('provider', ['youtube', 'vimeo', 's3_hls', 'self_hosted'])->default('youtube');
            $table->string('provider_key');
            $table->string('hls_manifest_url')->nullable();
            $table->unsignedInteger('duration_seconds')->default(0);
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon_path')->nullable();
            $table->timestamps();
        });

        Schema::create('courses', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('category_id')->constrained('categories')->onDelete('restrict');
            $table->foreignUlid('trainer_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->ulid('current_version_id')->nullable();
            $table->timestamps();

            $table->index('slug');
            $table->index('trainer_id');
        });

        Schema::create('course_versions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('version_code')->default('v1.0');
            $table->longText('description');
            $table->decimal('price', 10, 2)->default(0.00);
            $table->enum('level', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });

        Schema::create('modules', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('course_version_id')->constrained('course_versions')->onDelete('cascade');
            $table->string('title');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('lessons', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('module_id')->constrained('modules')->onDelete('cascade');
            $table->foreignUlid('media_asset_id')->nullable()->constrained('media_assets')->onDelete('set null');
            $table->string('title');
            $table->string('video_url')->nullable();
            $table->unsignedInteger('duration')->default(0);
            $table->boolean('is_free_preview')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('lesson_progress', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignUlid('lesson_id')->constrained('lessons')->onDelete('cascade');
            $table->unsignedInteger('watch_time_seconds')->default(0);
            $table->unsignedTinyInteger('watch_percentage')->default(0);
            $table->boolean('is_completed')->default(false);
            $table->timestamps();

            $table->unique(['user_id', 'lesson_id']);
            $table->index(['user_id', 'is_completed']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lesson_progress');
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('modules');
        Schema::dropIfExists('course_versions');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('media_assets');
    }
};
