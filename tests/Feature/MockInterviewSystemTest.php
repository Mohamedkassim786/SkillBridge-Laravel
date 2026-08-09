<?php

namespace Tests\Feature;

use App\Models\MockInterview;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class MockInterviewSystemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        if (!DB::table('roles')->where('name', 'student')->exists()) {
            DB::table('roles')->insert([
                'id' => (string) Str::ulid(),
                'name' => 'student',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function test_student_can_access_mock_interview_page(): void
    {
        $user = User::factory()->create();
        $user->assignRole('student');

        $response = $this->actingAs($user)->get(route('student.practice.mock'));

        $response->assertStatus(200);
    }

    public function test_mock_interview_creation_and_question_flow(): void
    {
        $user = User::factory()->create();
        $user->assignRole('student');

        $interview = MockInterview::create([
            'student_id' => $user->id,
            'interview_type' => 'technical',
            'role' => 'Laravel Developer',
            'technology' => 'Laravel 12',
            'difficulty' => 3,
            'mode' => 'real',
            'voice' => 'Magpie-Multilingual.EN-US.Aria',
            'status' => 'in_progress',
            'started_at' => now(),
        ]);

        $this->assertDatabaseHas('mock_interviews', [
            'id' => $interview->id,
            'role' => 'Laravel Developer',
            'status' => 'in_progress',
        ]);
    }
}
