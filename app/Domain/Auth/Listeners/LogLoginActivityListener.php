<?php

namespace App\Domain\Auth\Listeners;

use App\Domain\Auth\Events\UserLoggedInEvent;
use App\Models\AuditLog;

class LogLoginActivityListener
{
    public function handle(UserLoggedInEvent $event): void
    {
        AuditLog::create([
            'user_id' => $event->user->id,
            'action' => 'user_login',
            'auditable_type' => get_class($event->user),
            'auditable_id' => $event->user->id,
            'new_values' => json_encode(['ip' => $event->ipAddress, 'logged_at' => now()->toIso8601String()]),
            'ip_address' => $event->ipAddress,
        ]);
    }
}
