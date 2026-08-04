<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('login_histories', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamp('login_time');
            $table->timestamp('logout_time')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('browser', 100)->nullable();
            $table->string('operating_system', 100)->nullable();
            $table->string('device', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->enum('login_status', ['successful', 'failed', 'locked'])->default('successful');
            $table->string('failed_reason')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'login_time']);
            $table->index(['ip_address', 'login_time']);
            $table->index('login_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('login_histories');
    }
};
