<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\Course;
use App\Models\CourseVersion;
use App\Models\Enrollment;
use App\Models\LiveClass;
use App\Models\LiveClassAttendee;
use App\Models\User;
use App\Services\JitsiLiveClassService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class LiveClassTest extends TestCase
{
    use RefreshDatabase;

    protected User $trainer;
    protected User $student;
    protected User $unauthorizedStudent;
    protected User $admin;
    protected Course $course;
    protected Batch $batch;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed Spatie roles with ULID primary keys
        foreach (['super_admin', 'admin', 'staff', 'trainer', 'student'] as $roleName) {
            \App\Models\Role::firstOrCreate(['name' => $roleName], [
                'id' => (string) \Illuminate\Support\Str::ulid(),
                'guard_name' => 'web',
            ]);
        }

        // Create Trainer & Admin users
        $this->trainer = User::factory()->create(['first_name' => 'Trainer', 'last_name' => 'Marcus', 'status' => 'active']);
        $this->trainer->assignRole('staff');

        $this->admin = User::factory()->create(['first_name' => 'System', 'last_name' => 'Admin', 'status' => 'active']);
        $this->admin->assignRole('admin');

        // Create Students
        $this->student = User::factory()->create(['first_name' => 'John', 'last_name' => 'Student', 'status' => 'active']);
        $this->student->assignRole('student');
        \App\Models\UserProfile::create([
            'user_id' => $this->student->id,
            'profile_completion_percentage' => 100,
        ]);

        $this->unauthorizedStudent = User::factory()->create(['first_name' => 'Stranger', 'last_name' => 'Danger', 'status' => 'active']);
        $this->unauthorizedStudent->assignRole('student');
        \App\Models\UserProfile::create([
            'user_id' => $this->unauthorizedStudent->id,
            'profile_completion_percentage' => 100,
        ]);

        // Create Category
        $category = \App\Models\Category::create([
            'name' => 'Software Engineering',
            'slug' => 'software-engineering',
        ]);

        // Create Course & Cohort Batch
        $this->course = Course::create([
            'category_id' => $category->id,
            'trainer_id' => $this->trainer->id,
            'title' => 'Advanced Laravel Software Architecture',
            'slug' => 'advanced-laravel-architecture',
            'status' => 'published',
        ]);

        $version = CourseVersion::create([
            'course_id' => $this->course->id,
            'version_number' => 1,
            'status' => 'published',
            'level' => 'advanced',
            'description' => 'Advanced Laravel architecture course version description.',
        ]);

        $this->batch = Batch::create([
            'course_version_id' => $version->id,
            'name' => 'Cohort 2026 Alpha',
            'max_seats' => 50,
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d', strtotime('+3 months')),
        ]);

        // Enroll Student in course & batch
        Enrollment::create([
            'user_id' => $this->student->id,
            'course_id' => $this->course->id,
            'course_version_id' => $version->id,
            'cohort_id' => $this->batch->id,
            'status' => 'active',
        ]);
    }

    public function test_trainer_can_create_a_live_class(): void
    {
        Notification::fake();

        $response = $this->actingAs($this->trainer)->post(route('staff.live-classes.store'), [
            'title' => 'Live DDD Masterclass',
            'course_id' => $this->course->id,
            'batch_id' => $this->batch->id,
            'description' => 'Architectural pattern session',
            'start_date' => date('Y-m-d'),
            'start_time' => '18:00',
            'duration_minutes' => 60,
            'attendance_required' => 1,
            'recording_enabled' => 1,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('live_classes', [
            'title' => 'Live DDD Masterclass',
            'course_id' => $this->course->id,
            'trainer_id' => $this->trainer->id,
            'provider' => 'jitsi',
            'status' => 'scheduled',
        ]);
    }

    public function test_student_sees_only_assigned_live_classes(): void
    {
        $jitsiService = app(JitsiLiveClassService::class);

        $allowedClass = LiveClass::create([
            'course_id' => $this->course->id,
            'batch_id' => $this->batch->id,
            'trainer_id' => $this->trainer->id,
            'title' => 'Authorized Session',
            'room_name' => $jitsiService->generateRoomName(),
            'start_at' => now()->addHour(),
            'end_at' => now()->addHours(2),
            'duration_minutes' => 60,
            'created_by' => $this->trainer->id,
        ]);

        $response = $this->actingAs($this->student)->get(route('student.live-classes.index'));
        $response->assertOk();
        $response->assertSee('Authorized Session');
    }

    public function test_student_cannot_join_unauthorized_batch_class(): void
    {
        $jitsiService = app(JitsiLiveClassService::class);

        $liveClass = LiveClass::create([
            'course_id' => $this->course->id,
            'batch_id' => $this->batch->id,
            'trainer_id' => $this->trainer->id,
            'title' => 'Restricted Cohort Class',
            'room_name' => $jitsiService->generateRoomName(),
            'start_at' => now()->addHour(),
            'end_at' => now()->addHours(2),
            'duration_minutes' => 60,
            'created_by' => $this->trainer->id,
        ]);

        $response = $this->actingAs($this->unauthorizedStudent)->get(route('student.live-classes.show', $liveClass->id));
        $response->assertForbidden();
    }

    public function test_authorized_student_joining_creates_attendance(): void
    {
        $jitsiService = app(JitsiLiveClassService::class);

        $liveClass = LiveClass::create([
            'course_id' => $this->course->id,
            'batch_id' => $this->batch->id,
            'trainer_id' => $this->trainer->id,
            'title' => 'Live WebRTC Session',
            'room_name' => $jitsiService->generateRoomName(),
            'start_at' => now(),
            'end_at' => now()->addHour(),
            'duration_minutes' => 60,
            'status' => 'live',
            'created_by' => $this->trainer->id,
        ]);

        $response = $this->actingAs($this->student)->post(route('student.live-classes.post-join', $liveClass->id));
        $response->assertOk();

        $this->assertDatabaseHas('live_class_attendees', [
            'live_class_id' => $liveClass->id,
            'student_id' => $this->student->id,
            'attendance_status' => 'joined',
        ]);
    }

    public function test_heartbeat_updates_last_seen_and_duration(): void
    {
        $jitsiService = app(JitsiLiveClassService::class);

        $liveClass = LiveClass::create([
            'course_id' => $this->course->id,
            'batch_id' => $this->batch->id,
            'trainer_id' => $this->trainer->id,
            'title' => 'Heartbeat Test Session',
            'room_name' => $jitsiService->generateRoomName(),
            'start_at' => now()->subMinutes(30),
            'end_at' => now()->addMinutes(30),
            'duration_minutes' => 60,
            'status' => 'live',
            'created_by' => $this->trainer->id,
        ]);

        // First join
        $this->actingAs($this->student)->post(route('student.live-classes.post-join', $liveClass->id));

        // Heartbeat
        $response = $this->actingAs($this->student)->post(route('student.live-classes.heartbeat', $liveClass->id));
        $response->assertOk();
        $response->assertJsonStructure(['status', 'last_seen_at', 'duration_minutes', 'attendance_status']);
    }

    public function test_leaving_class_calculates_final_duration_and_status(): void
    {
        $jitsiService = app(JitsiLiveClassService::class);

        $liveClass = LiveClass::create([
            'course_id' => $this->course->id,
            'batch_id' => $this->batch->id,
            'trainer_id' => $this->trainer->id,
            'title' => 'Leave Session Test',
            'room_name' => $jitsiService->generateRoomName(),
            'start_at' => now()->subMinutes(40),
            'end_at' => now()->addMinutes(20),
            'duration_minutes' => 60,
            'status' => 'live',
            'created_by' => $this->trainer->id,
        ]);

        // Join 40 minutes ago
        LiveClassAttendee::create([
            'live_class_id' => $liveClass->id,
            'student_id' => $this->student->id,
            'joined_at' => now()->subMinutes(40),
            'last_seen_at' => now()->subMinutes(5),
            'attendance_status' => 'joined',
        ]);

        $response = $this->actingAs($this->student)->post(route('student.live-classes.leave', $liveClass->id));
        $response->assertOk();

        $this->assertDatabaseHas('live_class_attendees', [
            'live_class_id' => $liveClass->id,
            'student_id' => $this->student->id,
            'attendance_status' => 'attended', // > 50% of 60 mins => attended
        ]);
    }

    public function test_cancelled_class_cannot_be_joined(): void
    {
        $jitsiService = app(JitsiLiveClassService::class);

        $liveClass = LiveClass::create([
            'course_id' => $this->course->id,
            'batch_id' => $this->batch->id,
            'trainer_id' => $this->trainer->id,
            'title' => 'Cancelled Session',
            'room_name' => $jitsiService->generateRoomName(),
            'start_at' => now(),
            'end_at' => now()->addHour(),
            'duration_minutes' => 60,
            'status' => 'cancelled',
            'created_by' => $this->trainer->id,
        ]);

        $response = $this->actingAs($this->student)->get(route('student.live-classes.show', $liveClass->id));
        $response->assertForbidden();
    }

    public function test_trainer_can_view_attendance_and_export_csv(): void
    {
        $jitsiService = app(JitsiLiveClassService::class);

        $liveClass = LiveClass::create([
            'course_id' => $this->course->id,
            'batch_id' => $this->batch->id,
            'trainer_id' => $this->trainer->id,
            'title' => 'Attendance Export Session',
            'room_name' => $jitsiService->generateRoomName(),
            'start_at' => now(),
            'end_at' => now()->addHour(),
            'duration_minutes' => 60,
            'created_by' => $this->trainer->id,
        ]);

        $response = $this->actingAs($this->trainer)->get(route('staff.live-classes.attendance', $liveClass->id));
        $response->assertOk();

        $exportResponse = $this->actingAs($this->trainer)->get(route('staff.live-classes.export-attendance', $liveClass->id));
        $exportResponse->assertOk();
        $exportResponse->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    }

    public function test_recording_stays_private_until_published(): void
    {
        Storage::fake('private');

        $jitsiService = app(JitsiLiveClassService::class);

        $filePath = 'live_class_recordings/test.mp4';
        Storage::disk('private')->put($filePath, 'fake video stream content');

        $liveClass = LiveClass::create([
            'course_id' => $this->course->id,
            'batch_id' => $this->batch->id,
            'trainer_id' => $this->trainer->id,
            'title' => 'Recorded Session',
            'room_name' => $jitsiService->generateRoomName(),
            'start_at' => now()->subHours(3),
            'end_at' => now()->subHours(2),
            'duration_minutes' => 60,
            'status' => 'completed',
            'recording_url' => $filePath,
            'recording_status' => 'processing', // Not published yet
            'created_by' => $this->trainer->id,
        ]);

        // Student tries to view unpublished recording => 404
        $response = $this->actingAs($this->student)->get(route('student.live-classes.recording', $liveClass->id));
        $response->assertNotFound();

        // Publish recording
        $liveClass->update(['recording_status' => 'published']);

        // Student tries to view published recording => 200 OK stream
        $publishedResponse = $this->actingAs($this->student)->get(route('student.live-classes.recording', $liveClass->id));
        $publishedResponse->assertOk();
    }
}
