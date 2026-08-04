<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_cohorts', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('course_version_id')->constrained('course_versions')->onDelete('cascade');
            $table->string('name');
            $table->unsignedInteger('max_seats')->default(50);
            $table->string('live_meeting_url')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });

        Schema::create('enrollments', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')->constrained('users')->onDelete('restrict');
            $table->foreignUlid('course_id')->constrained('courses')->onDelete('restrict');
            $table->foreignUlid('course_version_id')->constrained('course_versions')->onDelete('restrict');
            $table->foreignUlid('cohort_id')->nullable()->constrained('course_cohorts')->onDelete('set null');
            $table->unsignedTinyInteger('progress_percent')->default(0);
            $table->enum('status', ['active', 'completed', 'refunded'])->default('active');
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'course_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
        Schema::dropIfExists('course_cohorts');
    }
};
