<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\LiveClasses\StoreLiveClassRequest;
use App\Http\Requests\LiveClasses\UpdateLiveClassRequest;
use App\Http\Requests\LiveClasses\UploadRecordingRequest;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\LiveClass;
use App\Models\LiveClassMaterial;
use App\Notifications\LiveClasses\LiveClassCreatedNotification;
use App\Domain\LiveClasses\Services\JitsiLiveClassService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class LiveClassController extends Controller
{
    protected JitsiLiveClassService $jitsiService;

    public function __construct(JitsiLiveClassService $jitsiService)
    {
        $this->jitsiService = $jitsiService;
    }

    public function index(Request $request)
    {
        $user = auth()->user();

        $query = LiveClass::with(['course', 'batch', 'attendees'])
            ->where(function ($q) use ($user) {
                $q->where('trainer_id', $user->id)
                  ->orWhere('created_by', $user->id);
            });

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->filled('batch_id')) {
            $query->where('batch_id', $request->batch_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $liveClasses = $query->orderBy('start_at', 'desc')->paginate(12);

        $courses = Course::orderBy('title')->get();
        $batches = Batch::orderBy('name')->get();

        return view('staff.live-classes.index', compact('liveClasses', 'courses', 'batches'));
    }

    public function create()
    {
        $user = auth()->user();
        $courses = Course::orderBy('title')->get();
        $batches = Batch::with('courseVersion.course')->orderBy('name')->get();

        return view('staff.live-classes.create', compact('courses', 'batches'));
    }

    public function store(StoreLiveClassRequest $request)
    {
        $user = auth()->user();

        $startAt = Carbon::parse($request->start_date . ' ' . $request->start_time);
        $duration = (int) $request->duration_minutes;
        $endAt = (clone $startAt)->addMinutes($duration);

        $roomName = $this->jitsiService->generateRoomName();

        DB::beginTransaction();
        try {
            $liveClass = LiveClass::create([
                'course_id' => $request->course_id,
                'batch_id' => $request->batch_id,
                'trainer_id' => $user->id,
                'title' => $request->title,
                'description' => $request->description,
                'room_name' => $roomName,
                'provider' => 'jitsi',
                'start_at' => $startAt,
                'end_at' => $endAt,
                'duration_minutes' => $duration,
                'status' => 'scheduled',
                'attendance_required' => $request->boolean('attendance_required', true),
                'recording_enabled' => $request->boolean('recording_enabled', true),
                'created_by' => $user->id,
            ]);

            // Save uploaded materials if provided
            if ($request->has('materials') && is_array($request->materials)) {
                foreach ($request->materials as $mat) {
                    $filePath = null;
                    if (isset($mat['file']) && $mat['file'] instanceof \Illuminate\Http\UploadedFile) {
                        $filePath = $mat['file']->store('live_class_materials/' . $liveClass->id, 'private');
                    }

                    LiveClassMaterial::create([
                        'live_class_id' => $liveClass->id,
                        'title' => $mat['title'],
                        'type' => $mat['type'] ?? 'pdf',
                        'file_path' => $filePath,
                        'external_url' => $mat['external_url'] ?? null,
                        'created_by' => $user->id,
                    ]);
                }
            }

            DB::commit();

            // Send real in-app notifications to enrolled students
            $students = Enrollment::where('course_id', $request->course_id)
                ->when($request->batch_id, fn($q) => $q->where('cohort_id', $request->batch_id))
                ->where('status', 'active')
                ->with('user')
                ->get()
                ->pluck('user')
                ->filter();

            if ($students->isNotEmpty()) {
                Notification::send($students, new LiveClassCreatedNotification($liveClass));
            }

            return redirect()->route('staff.live-classes.show', $liveClass->id)
                ->with('status', 'Live masterclass scheduled successfully and notification sent to enrolled students!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('warning', 'Failed to create live class: ' . $e->getMessage());
        }
    }

    public function show(LiveClass $liveClass)
    {
        $this->authorize('view', $liveClass);

        $liveClass->load(['course', 'batch', 'trainer', 'creator', 'attendees.student', 'materials', 'feedbacks.student']);

        $totalEnrolled = Enrollment::where('course_id', $liveClass->course_id)
            ->when($liveClass->batch_id, fn($q) => $q->where('cohort_id', $liveClass->batch_id))
            ->where('status', 'active')
            ->count();

        $attendedCount = $liveClass->attendees->whereIn('attendance_status', ['attended', 'joined', 'partial'])->count();
        $attendancePercentage = $totalEnrolled > 0 ? round(($attendedCount / $totalEnrolled) * 100, 1) : 0;

        return view('staff.live-classes.show', compact('liveClass', 'totalEnrolled', 'attendedCount', 'attendancePercentage'));
    }

    public function edit(LiveClass $liveClass)
    {
        $this->authorize('update', $liveClass);

        $courses = Course::orderBy('title')->get();
        $batches = Batch::orderBy('name')->get();

        return view('staff.live-classes.edit', compact('liveClass', 'courses', 'batches'));
    }

    public function update(UpdateLiveClassRequest $request, LiveClass $liveClass)
    {
        $this->authorize('update', $liveClass);

        $startAt = Carbon::parse($request->start_date . ' ' . $request->start_time);
        $duration = (int) $request->duration_minutes;
        $endAt = (clone $startAt)->addMinutes($duration);

        $updateData = [
            'title' => $request->title,
            'description' => $request->description,
            'start_at' => $startAt,
            'end_at' => $endAt,
            'duration_minutes' => $duration,
            'attendance_required' => $request->boolean('attendance_required', true),
            'recording_enabled' => $request->boolean('recording_enabled', true),
        ];

        if ($request->filled('status')) {
            $updateData['status'] = $request->status;
            if ($request->status === 'cancelled') {
                $updateData['cancelled_at'] = now();
                $updateData['cancellation_reason'] = $request->cancellation_reason;
            }
        }

        $liveClass->update($updateData);

        return redirect()->route('staff.live-classes.show', $liveClass->id)
            ->with('status', 'Masterclass details updated successfully.');
    }

    public function destroy(LiveClass $liveClass)
    {
        $this->authorize('delete', $liveClass);

        $liveClass->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => 'Cancelled by trainer',
        ]);

        return redirect()->route('staff.live-classes.index')
            ->with('status', 'Live masterclass cancelled.');
    }

    public function join(LiveClass $liveClass)
    {
        $this->authorize('join', $liveClass);

        $user = auth()->user();
        $meetingOptions = $this->jitsiService->getMeetingOptions($liveClass, $user);

        // Update status to live if starting
        if (in_array($liveClass->status, ['scheduled', 'starting_soon'])) {
            $liveClass->update(['status' => 'live']);
        }

        return view('staff.live-classes.join', compact('liveClass', 'meetingOptions'));
    }

    public function end(LiveClass $liveClass)
    {
        $this->authorize('update', $liveClass);

        $liveClass->update([
            'status' => 'completed',
            'end_at' => now(),
        ]);

        return redirect()->route('staff.live-classes.show', $liveClass->id)
            ->with('status', 'Masterclass broadcast completed!');
    }

    public function attendance(LiveClass $liveClass)
    {
        $this->authorize('viewAttendance', $liveClass);

        $liveClass->load(['course', 'batch', 'attendees.student']);

        $totalEnrolled = Enrollment::where('course_id', $liveClass->course_id)
            ->when($liveClass->batch_id, fn($q) => $q->where('cohort_id', $liveClass->batch_id))
            ->where('status', 'active')
            ->count();

        $attendedCount = $liveClass->attendees->whereIn('attendance_status', ['attended', 'joined', 'partial'])->count();
        $attendancePercentage = $totalEnrolled > 0 ? round(($attendedCount / $totalEnrolled) * 100, 1) : 0;

        return view('staff.live-classes.attendance', compact('liveClass', 'totalEnrolled', 'attendedCount', 'attendancePercentage'));
    }

    public function exportAttendanceCsv(LiveClass $liveClass)
    {
        $this->authorize('viewAttendance', $liveClass);

        $attendees = $liveClass->attendees()->with('student')->get();

        $filename = "attendance_{$liveClass->id}_" . date('Y-m-d') . ".csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$filename}",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($attendees, $liveClass) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Student Name', 'Email', 'Joined Time', 'Left Time', 'Duration (Mins)', 'Attendance Status', 'IP Address']);

            foreach ($attendees as $att) {
                fputcsv($file, [
                    $att->student?->name ?? 'Student',
                    $att->student?->email ?? 'N/A',
                    $att->joined_at ? $att->joined_at->format('Y-m-d H:i:s') : 'N/A',
                    $att->left_at ? $att->left_at->format('Y-m-d H:i:s') : 'N/A',
                    $att->duration_minutes,
                    strtoupper($att->attendance_status),
                    $att->ip_address ?? 'N/A'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function uploadRecording(UploadRecordingRequest $request, LiveClass $liveClass)
    {
        $this->authorize('uploadRecording', $liveClass);

        $file = $request->file('recording_file');
        $filePath = $file->store('live_class_recordings/' . $liveClass->id, 'private');

        $liveClass->update([
            'recording_url' => $filePath,
            'recording_status' => 'processing',
        ]);

        return redirect()->route('staff.live-classes.show', $liveClass->id)
            ->with('status', 'Masterclass recording uploaded successfully!');
    }

    public function publishRecording(LiveClass $liveClass)
    {
        $this->authorize('publishRecording', $liveClass);

        $liveClass->update([
            'recording_status' => 'published',
            'published_at' => now(),
        ]);

        // Send notifications to enrolled students
        $students = Enrollment::where('course_id', $liveClass->course_id)
            ->when($liveClass->batch_id, fn($q) => $q->where('cohort_id', $liveClass->batch_id))
            ->where('status', 'active')
            ->with('user')
            ->get()
            ->pluck('user')
            ->filter();

        if ($students->isNotEmpty()) {
            Notification::send($students, new \App\Notifications\LiveClasses\RecordingPublishedNotification($liveClass));
        }

        return redirect()->route('staff.live-classes.show', $liveClass->id)
            ->with('status', 'Recording published! Enrolled students can now watch the session.');
    }
}
