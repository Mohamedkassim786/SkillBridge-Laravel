<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coding_challenges', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('difficulty')->default('Medium'); // Easy, Medium, Hard
            $table->string('category')->default('Algorithms'); // Algorithms, Data Structures, System Design
            $table->text('description');
            $table->text('starter_code');
            $table->json('test_cases');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coding_challenges');
    }
};
