<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLiveClassRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole(['staff', 'trainer', 'admin', 'super_admin']);
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'batch_id' => 'nullable|exists:course_cohorts,id',
            'description' => 'nullable|string|max:2000',
            'start_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'duration_minutes' => 'required|integer|min:15|max:480',
            'attendance_required' => 'boolean',
            'recording_enabled' => 'boolean',
            'materials' => 'nullable|array',
            'materials.*.title' => 'required_with:materials|string|max:255',
            'materials.*.type' => 'required_with:materials|in:pdf,document,link,assignment',
            'materials.*.external_url' => 'nullable|url|max:1000',
            'materials.*.file' => 'nullable|file|mimes:pdf,doc,docx,zip|max:20480',
        ];
    }
}
