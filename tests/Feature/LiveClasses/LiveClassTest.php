<?php

namespace Tests\Feature\LiveClasses;

use App\Models\Batch;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseVersion;
use App\Models\Enrollment;
use App\Models\LiveClass;
use App\Models\LiveClassAttendee;
use App\Models\Role;
use App\Models\User;
use App\Models\UserProfile;
use App\Domain\LiveClasses\Services\JitsiLiveClassService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LiveClassTest extends TestCase
{
    use RefreshDatabase;

    protected User $trainer;
    protected User $student;
    protected User $admin;
    protected Course $course;
    protected CourseVersion $courseVersion;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'trainer', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);

        $this->trainer = User::factory()->create(['status' => 'active']);
        $this->trainer->assignRole('staff');
        UserProfile::create(['user_id' => $this->trainer->id, 'profile_completion_percentage' => 100]);

        $this->student = User::factory()->create(['status' => 'active']);
        $this->student->assignRole('student');
        UserProfile::create(['user_id' => $this->student->id, 'profile_completion_percentage' => 100]);

        $this->admin = User::factory()->create(['status' => 'active']);
        $this->admin->assignRole('admin');
        UserProfile::create(['user_id' => $this->admin->id, 'profile_completion_percentage' => 100]);

        $category = Category::create([
            'name' => 'Web Development',
            'slug' => 'web-development',
        ]);

        $this->course = Course::create([
            'category_id' => $category->id,
            'title' => 'Mastering WebRTC & Laravel 12',
            'slug' => 'webrtc-laravel-12',
            'trainer_id' => $this->trainer->id,
            'is_published' => true,
        ]);

        $this->courseVersion = CourseVersion::create([
            'course_id' => $this->course->id,
            'version_code' => 'v1.0',
            'description' => 'Test course version description',
            'price' => 99.00,
            'is_published' => true,
        ]);

        $this->course->update(['current_version_id' => $this->courseVersion->id]);
    }

    public function test_trainer_can_create_live_class(): void
    {
        $response = $this->actingAs($this->trainer)->post(route('staff.live-classes.store'), [
            'title' => 'Live Architecture Q&A',
            'course_id' => $this->course->id,
            'start_date' => Carbon::tomorrow()->format('Y-m-d'),
            'start_time' => '14:00',
            'duration_minutes' => 60,
            'recording_enabled' => true,
            'attendance_required' => true,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('live_classes', [
            'title' => 'Live Architecture Q&A',
            'course_id' => $this->course->id,
            'trainer_id' => $this->trainer->id,
            'recording_enabled' => true,
        ]);
    }

    public function test_unauthorized_user_cannot_create_live_class(): void
    {
        $response = $this->actingAs($this->student)->post(route('staff.live-classes.store'), [
            'title' => 'Hacked Class',
            'course_id' => $this->course->id,
            'start_date' => Carbon::tomorrow()->format('Y-m-d'),
            'start_time' => '14:00',
            'duration_minutes' => 60,
        ]);

        $response->assertStatus(403);
    }

    public function test_enrolled_student_can_join_live_class(): void
    {
        Enrollment::create([
            'user_id' => $this->student->id,
            'course_id' => $this->course->id,
            'course_version_id' => $this->courseVersion->id,
            'status' => 'active',
        ]);

        $liveClass = LiveClass::create([
            'title' => 'Interactive Workshop',
            'course_id' => $this->course->id,
            'trainer_id' => $this->trainer->id,
            'created_by' => $this->trainer->id,
            'room_name' => 'live_class_test_123',
            'start_at' => Carbon::now()->subMinutes(5),
            'end_at' => Carbon::now()->addMinutes(55),
            'duration_minutes' => 60,
            'status' => 'live',
        ]);

        $response = $this->actingAs($this->student)->get(route('student.live-classes.join', $liveClass->id));
        $response->assertStatus(200);

        $this->assertDatabaseHas('live_class_attendees', [
            'live_class_id' => $liveClass->id,
            'student_id' => $this->student->id,
            'attendance_status' => 'joined',
        ]);
    }

    public function test_non_enrolled_student_cannot_join_live_class(): void
    {
        $liveClass = LiveClass::create([
            'title' => 'Private Workshop',
            'course_id' => $this->course->id,
            'trainer_id' => $this->trainer->id,
            'created_by' => $this->trainer->id,
            'room_name' => 'live_class_private_123',
            'start_at' => Carbon::now(),
            'end_at' => Carbon::now()->addHour(),
            'duration_minutes' => 60,
            'status' => 'live',
        ]);

        $response = $this->actingAs($this->student)->get(route('student.live-classes.join', $liveClass->id));
        $response->assertStatus(403);
    }

    public function test_student_heartbeat_updates_duration_and_status(): void
    {
        Enrollment::create([
            'user_id' => $this->student->id,
            'course_id' => $this->course->id,
            'course_version_id' => $this->courseVersion->id,
            'status' => 'active',
        ]);

        $liveClass = LiveClass::create([
            'title' => 'Heartbeat Test Class',
            'course_id' => $this->course->id,
            'trainer_id' => $this->trainer->id,
            'created_by' => $this->trainer->id,
            'room_name' => 'live_class_hb_123',
            'start_at' => Carbon::now()->subMinutes(35),
            'end_at' => Carbon::now()->addMinutes(25),
            'duration_minutes' => 60,
            'status' => 'live',
        ]);

        LiveClassAttendee::create([
            'live_class_id' => $liveClass->id,
            'student_id' => $this->student->id,
            'joined_at' => Carbon::now()->subMinutes(35),
            'last_seen_at' => Carbon::now()->subMinutes(35),
            'attendance_status' => 'joined',
        ]);

        $response = $this->actingAs($this->student)->post(route('student.live-classes.heartbeat', $liveClass->id));

        $response->assertJson(['status' => 'success']);
        $this->assertDatabaseHas('live_class_attendees', [
            'live_class_id' => $liveClass->id,
            'student_id' => $this->student->id,
            'attendance_status' => 'attended',
        ]);
    }

    public function test_jitsi_service_calculates_attendance_rules_correctly(): void
    {
        $jitsiService = app(JitsiLiveClassService::class);

        $this->assertEquals('absent', $jitsiService->calculateAttendanceStatus(5, 60));
        $this->assertEquals('partial', $jitsiService->calculateAttendanceStatus(25, 60));
        $this->assertEquals('attended', $jitsiService->calculateAttendanceStatus(30, 60));
        $this->assertEquals('attended', $jitsiService->calculateAttendanceStatus(55, 60));
    }

    public function test_recording_privacy_prevents_unauthorized_access(): void
    {
        Storage::fake('private');

        $liveClass = LiveClass::create([
            'title' => 'Recorded Lecture',
            'course_id' => $this->course->id,
            'trainer_id' => $this->trainer->id,
            'created_by' => $this->trainer->id,
            'room_name' => 'live_class_rec_123',
            'start_at' => Carbon::yesterday(),
            'end_at' => Carbon::yesterday()->addHour(),
            'duration_minutes' => 60,
            'status' => 'completed',
            'recording_url' => 'recordings/live-classes/test_rec.mp4',
            'recording_status' => 'published',
        ]);

        Storage::disk('private')->put('recordings/live-classes/test_rec.mp4', 'dummy video content');

        // Unenrolled student attempt
        $response = $this->actingAs($this->student)->get(route('student.live-classes.recording', $liveClass->id));
        $response->assertStatus(403);

        // Enrolled student attempt
        Enrollment::create([
            'user_id' => $this->student->id,
            'course_id' => $this->course->id,
            'course_version_id' => $this->courseVersion->id,
            'status' => 'active',
        ]);

        $validResponse = $this->actingAs($this->student)->get(route('student.live-classes.recording', $liveClass->id));
        $validResponse->assertStatus(200);
    }
}
