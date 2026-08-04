<?php

namespace App\Domain\Auth\Contracts;

use App\Models\LoginHistory;

interface LoginHistoryRepositoryInterface
{
    public function record(array $data): LoginHistory;

    public function recordLogout(string $loginHistoryId): void;

    public function getRecentFailedAttempts(string $email, int $withinMinutes = 15): int;
}
