<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mock_interviews', function (Blueprint $table) {
            if (!Schema::hasColumn('mock_interviews', 'interview_state')) {
                $table->json('interview_state')->nullable()->after('difficulty');
            }
            if (!Schema::hasColumn('mock_interviews', 'max_questions')) {
                $table->unsignedInteger('max_questions')->default(10)->after('interview_state');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mock_interviews', function (Blueprint $table) {
            if (Schema::hasColumn('mock_interviews', 'interview_state')) {
                $table->dropColumn('interview_state');
            }
            if (Schema::hasColumn('mock_interviews', 'max_questions')) {
                $table->dropColumn('max_questions');
            }
        });
    }
};
