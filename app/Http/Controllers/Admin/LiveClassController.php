<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\LiveClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LiveClassController extends Controller
{
    public function index(Request $request)
    {
        $query = LiveClass::with(['course', 'batch', 'trainer', 'attendees']);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $liveClasses = $query->orderBy('start_at', 'desc')->paginate(15);

        return view('admin.live-classes.index', compact('liveClasses'));
    }

    public function show(LiveClass $liveClass)
    {
        $liveClass->load(['course', 'batch', 'trainer', 'creator', 'attendees.student', 'materials', 'feedbacks.student']);

        $totalEnrolled = Enrollment::where('course_id', $liveClass->course_id)
            ->when($liveClass->batch_id, fn($q) => $q->where('cohort_id', $liveClass->batch_id))
            ->where('status', 'active')
            ->count();

        $attendedCount = $liveClass->attendees->whereIn('attendance_status', ['attended', 'joined', 'partial'])->count();
        $attendancePercentage = $totalEnrolled > 0 ? round(($attendedCount / $totalEnrolled) * 100, 1) : 0;

        return view('admin.live-classes.show', compact('liveClass', 'totalEnrolled', 'attendedCount', 'attendancePercentage'));
    }

    public function attendance(LiveClass $liveClass)
    {
        $liveClass->load(['course', 'batch', 'attendees.student']);

        $totalEnrolled = Enrollment::where('course_id', $liveClass->course_id)
            ->when($liveClass->batch_id, fn($q) => $q->where('cohort_id', $liveClass->batch_id))
            ->where('status', 'active')
            ->count();

        $attendedCount = $liveClass->attendees->whereIn('attendance_status', ['attended', 'joined', 'partial'])->count();
        $attendancePercentage = $totalEnrolled > 0 ? round(($attendedCount / $totalEnrolled) * 100, 1) : 0;

        return view('admin.live-classes.attendance', compact('liveClass', 'totalEnrolled', 'attendedCount', 'attendancePercentage'));
    }

    public function cancel(Request $request, LiveClass $liveClass)
    {
        $request->validate([
            'cancellation_reason' => 'required|string|max:1000',
        ]);

        $liveClass->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => $request->cancellation_reason,
        ]);

        return back()->with('status', 'Live masterclass cancelled by Admin.');
    }

    public function reschedule(Request $request, LiveClass $liveClass)
    {
        $request->validate([
            'start_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'duration_minutes' => 'required|integer|min:15|max:480',
        ]);

        $startAt = \Carbon\Carbon::parse($request->start_date . ' ' . $request->start_time);
        $duration = (int) $request->duration_minutes;
        $endAt = (clone $startAt)->addMinutes($duration);

        $liveClass->update([
            'start_at' => $startAt,
            'end_at' => $endAt,
            'duration_minutes' => $duration,
            'status' => 'scheduled',
        ]);

        return back()->with('status', 'Live masterclass rescheduled successfully.');
    }

    public function streamRecording(LiveClass $liveClass)
    {
        if (! $liveClass->recording_url || ! Storage::disk('private')->exists($liveClass->recording_url)) {
            abort(404, 'Recording file not found.');
        }

        return Storage::disk('private')->response($liveClass->recording_url);
    }
}
