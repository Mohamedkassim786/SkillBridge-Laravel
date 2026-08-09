<?php

namespace App\Notifications\LiveClasses;

use App\Models\LiveClass;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class RecordingPublishedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public LiveClass $liveClass;

    public function __construct(LiveClass $liveClass)
    {
        $this->liveClass = $liveClass;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'recording_published',
            'title' => '📹 Recording Published: ' . $this->liveClass->title,
            'message' => 'The video recording for your masterclass is now published and available to stream.',
            'live_class_id' => $this->liveClass->id,
            'action_url' => route('student.live-classes.show', $this->liveClass->id),
        ];
    }
}
