<?php

namespace App\Http\Requests\LiveClasses;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLiveClassRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole(['staff', 'trainer', 'admin', 'super_admin']);
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'start_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'duration_minutes' => 'required|integer|min:15|max:480',
            'attendance_required' => 'boolean',
            'recording_enabled' => 'boolean',
            'status' => 'nullable|in:scheduled,starting_soon,live,completed,cancelled',
            'cancellation_reason' => 'nullable|required_if:status,cancelled|string|max:1000',
        ];
    }
}
