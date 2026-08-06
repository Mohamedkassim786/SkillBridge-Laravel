<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('live_classes', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignUlid('batch_id')->nullable()->constrained('course_cohorts')->onDelete('set null');
            $table->foreignUlid('trainer_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('room_name')->unique();
            $table->string('provider')->default('jitsi');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->unsignedInteger('duration_minutes');
            $table->enum('status', ['scheduled', 'starting_soon', 'live', 'completed', 'cancelled'])->default('scheduled');
            $table->boolean('attendance_required')->default(true);
            $table->boolean('recording_enabled')->default(true);
            $table->string('recording_url')->nullable();
            $table->enum('recording_status', ['unavailable', 'processing', 'published', 'hidden'])->default('unavailable');
            $table->timestamp('published_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->foreignUlid('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->index(['course_id', 'status']);
            $table->index(['trainer_id', 'status']);
            $table->index(['start_at', 'status']);
        });

        Schema::create('live_class_attendees', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('live_class_id')->constrained('live_classes')->onDelete('cascade');
            $table->foreignUlid('student_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('joined_at')->nullable();
            $table->timestamp('left_at')->nullable();
            $table->timestamp('last_seen_at')->nullable();
            $table->unsignedInteger('duration_minutes')->default(0);
            $table->enum('attendance_status', ['registered', 'joined', 'partial', 'attended', 'absent'])->default('registered');
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            $table->unique(['live_class_id', 'student_id']);
            $table->index(['live_class_id', 'attendance_status']);
        });

        Schema::create('live_class_materials', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('live_class_id')->constrained('live_classes')->onDelete('cascade');
            $table->string('title');
            $table->enum('type', ['pdf', 'document', 'link', 'assignment'])->default('pdf');
            $table->string('file_path')->nullable();
            $table->string('external_url')->nullable();
            $table->foreignUlid('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('live_class_feedback', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('live_class_id')->constrained('live_classes')->onDelete('cascade');
            $table->foreignUlid('student_id')->constrained('users')->onDelete('cascade');
            $table->unsignedTinyInteger('rating');
            $table->text('feedback')->nullable();
            $table->timestamps();

            $table->unique(['live_class_id', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('live_class_feedback');
        Schema::dropIfExists('live_class_materials');
        Schema::dropIfExists('live_class_attendees');
        Schema::dropIfExists('live_classes');
    }
};
