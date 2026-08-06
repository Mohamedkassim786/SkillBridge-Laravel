<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubmitFeedbackRequest;
use App\Models\Enrollment;
use App\Models\LiveClass;
use App\Models\LiveClassFeedback;
use App\Services\JitsiLiveClassService;
use Illuminate\Http\Request;
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

        // Get enrolled course IDs and cohort IDs
        $enrollments = Enrollment::where('user_id', $user->id)
            ->where('status', 'active')
            ->get();

        $enrolledCourseIds = $enrollments->pluck('course_id');
        $enrolledCohortIds = $enrollments->pluck('cohort_id')->filter();

        $query = LiveClass::with(['course', 'batch', 'trainer', 'attendees' => function ($q) use ($user) {
            $q->where('student_id', $user->id);
        }])
        ->whereIn('course_id', $enrolledCourseIds)
        ->where(function ($q) use ($enrolledCohortIds) {
            $q->whereNull('batch_id')
              ->orWhereIn('batch_id', $enrolledCohortIds);
        });

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $liveClasses = $query->orderBy('start_at', 'asc')->paginate(12);

        return view('student.live-classes.index', compact('liveClasses'));
    }

    public function show(LiveClass $liveClass)
    {
        $this->authorize('view', $liveClass);

        $user = auth()->user();
        $liveClass->load(['course', 'batch', 'trainer', 'materials', 'feedbacks']);

        $attendee = $liveClass->attendees()->where('student_id', $user->id)->first();
        $userFeedback = $liveClass->feedbacks()->where('student_id', $user->id)->first();

        return view('student.live-classes.show', compact('liveClass', 'attendee', 'userFeedback'));
    }

    public function joinRoom(LiveClass $liveClass)
    {
        $this->authorize('join', $liveClass);

        $user = auth()->user();
        $meetingOptions = $this->jitsiService->getMeetingOptions($liveClass, $user);

        // Record join timestamp
        $this->jitsiService->recordJoin($liveClass, $user, request()->ip());

        return view('student.live-classes.join', compact('liveClass', 'meetingOptions'));
    }

    public function join(LiveClass $liveClass, Request $request)
    {
        $this->authorize('join', $liveClass);

        $user = auth()->user();
        $attendee = $this->jitsiService->recordJoin($liveClass, $user, $request->ip());

        return response()->json([
            'status' => 'success',
            'attendee_id' => $attendee->id,
            'joined_at' => $attendee->joined_at->toIso8601String(),
        ]);
    }

    public function heartbeat(LiveClass $liveClass, Request $request)
    {
        $this->authorize('join', $liveClass);

        $user = auth()->user();
        $attendee = $this->jitsiService->recordHeartbeat($liveClass, $user);

        return response()->json([
            'status' => 'success',
            'last_seen_at' => $attendee->last_seen_at->toIso8601String(),
            'duration_minutes' => $attendee->duration_minutes,
            'attendance_status' => $attendee->attendance_status,
        ]);
    }

    public function leave(LiveClass $liveClass, Request $request)
    {
        $this->authorize('join', $liveClass);

        $user = auth()->user();
        $attendee = $this->jitsiService->recordLeave($liveClass, $user);

        return response()->json([
            'status' => 'success',
            'left_at' => $attendee?->left_at?->toIso8601String(),
            'duration_minutes' => $attendee?->duration_minutes ?? 0,
            'attendance_status' => $attendee?->attendance_status ?? 'absent',
        ]);
    }

    public function streamRecording(LiveClass $liveClass)
    {
        $this->authorize('view', $liveClass);

        if (! $liveClass->isPublishedRecording()) {
            abort(404, 'Recording unavailable or not published.');
        }

        $path = $liveClass->recording_url;

        if (! Storage::disk('private')->exists($path)) {
            abort(404, 'Recording video file not found.');
        }

        return Storage::disk('private')->response($path);
    }

    public function submitFeedback(SubmitFeedbackRequest $request, LiveClass $liveClass)
    {
        $this->authorize('view', $liveClass);

        $user = auth()->user();

        LiveClassFeedback::updateOrCreate(
            [
                'live_class_id' => $liveClass->id,
                'student_id' => $user->id,
            ],
            [
                'rating' => $request->rating,
                'feedback' => $request->feedback,
            ]
        );

        return back()->with('status', 'Thank you for your feedback!');
    }
}
