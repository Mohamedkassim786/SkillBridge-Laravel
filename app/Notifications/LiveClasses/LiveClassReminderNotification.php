<?php

namespace App\Notifications\LiveClasses;

use App\Models\LiveClass;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class LiveClassReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public LiveClass $liveClass;
    public string $timeframe;

    public function __construct(LiveClass $liveClass, string $timeframe = '10m')
    {
        $this->liveClass = $liveClass;
        $this->timeframe = $timeframe;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        $label = match ($this->timeframe) {
            '24h' => 'starts in 24 hours',
            '1h' => 'starts in 1 hour',
            default => 'is starting in 10 minutes',
        };

        return [
            'type' => 'live_class_reminder',
            'title' => '⏰ Reminder: ' . $this->liveClass->title . ' ' . $label,
            'message' => 'Get ready! Your live masterclass session ' . $label . '.',
            'live_class_id' => $this->liveClass->id,
            'action_url' => route('student.live-classes.show', $this->liveClass->id),
        ];
    }
}
