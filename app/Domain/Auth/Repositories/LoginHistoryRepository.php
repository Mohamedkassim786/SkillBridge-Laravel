<?php

namespace App\Domain\Auth\Repositories;

use App\Domain\Auth\Contracts\LoginHistoryRepositoryInterface;
use App\Models\LoginHistory;

class LoginHistoryRepository implements LoginHistoryRepositoryInterface
{
    public function record(array $data): LoginHistory
    {
        return LoginHistory::create($data);
    }

    public function recordLogout(string $loginHistoryId): void
    {
        LoginHistory::where('id', $loginHistoryId)->update(['logout_time' => now()]);
    }

    public function getRecentFailedAttempts(string $email, int $withinMinutes = 15): int
    {
        return LoginHistory::where('failed_reason', 'LIKE', "%{$email}%")
            ->where('login_status', 'failed')
            ->where('login_time', '>=', now()->subMinutes($withinMinutes))
            ->count();
    }
}
