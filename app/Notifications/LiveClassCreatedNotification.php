<?php

namespace App\Notifications;

use App\Models\LiveClass;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class LiveClassCreatedNotification extends Notification implements ShouldQueue
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
            'type' => 'live_class_created',
            'title' => '🚀 New Live Masterclass Scheduled: ' . $this->liveClass->title,
            'message' => 'A new live session has been scheduled for ' . $this->liveClass->start_at->format('M d, Y @ h:i A') . '.',
            'live_class_id' => $this->liveClass->id,
            'action_url' => route('student.live-classes.show', $this->liveClass->id),
        ];
    }
}
