<?php

namespace App\Domain\Auth\Services;

use App\Domain\Auth\Contracts\LoginHistoryRepositoryInterface;
use App\Domain\Auth\Contracts\UserRepositoryInterface;
use App\Domain\Auth\Events\AccountLockedEvent;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class AccountLockoutService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected LoginHistoryRepositoryInterface $loginHistoryRepository
    ) {}

    public function handleFailedAttempt(string $email, ?string $ipAddress = null, ?string $userAgent = null): void
    {
        $cacheKey = 'failed_login_attempts:'.strtolower(trim($email));
        $attempts = (int) Cache::get($cacheKey, 0) + 1;
        Cache::put($cacheKey, $attempts, now()->addMinutes(15));

        $user = $this->userRepository->findByEmail($email);

        $this->loginHistoryRepository->record([
            'user_id' => $user?->id,
            'login_time' => now(),
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'login_status' => 'failed',
            'failed_reason' => "Failed login attempt {$attempts} for email {$email}",
        ]);

        if ($attempts >= 5 && $user) {
            $this->userRepository->lockAccount($user, 15);
            event(new AccountLockedEvent($user, $ipAddress ?? '127.0.0.1'));
            Cache::forget($cacheKey);
        }
    }

    public function clearAttempts(string $email): void
    {
        Cache::forget('failed_login_attempts:'.strtolower(trim($email)));
    }
}
