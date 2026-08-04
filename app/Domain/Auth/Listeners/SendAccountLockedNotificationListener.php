<?php

namespace App\Domain\Auth\Listeners;

use App\Domain\Auth\Events\AccountLockedEvent;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Log;

class SendAccountLockedNotificationListener
{
    public function handle(AccountLockedEvent $event): void
    {
        Log::warning("Account locked for user {$event->user->email} from IP {$event->ipAddress}");

        AuditLog::create([
            'user_id' => $event->user->id,
            'action' => 'account_locked_failed_attempts',
            'auditable_type' => get_class($event->user),
            'auditable_id' => $event->user->id,
            'new_values' => json_encode(['ip' => $event->ipAddress, 'locked_at' => now()->toIso8601String()]),
            'ip_address' => $event->ipAddress,
        ]);
    }
}
