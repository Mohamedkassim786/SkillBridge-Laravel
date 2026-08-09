<?php

namespace App\Http\Requests\LiveClasses;

use Illuminate\Foundation\Http\FormRequest;

class UploadRecordingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole(['staff', 'trainer', 'admin', 'super_admin']);
    }

    public function rules(): array
    {
        return [
            'recording_file' => 'required|file|mimes:mp4,webm,mkv,mov|max:512000', // max 500MB
        ];
    }
}
