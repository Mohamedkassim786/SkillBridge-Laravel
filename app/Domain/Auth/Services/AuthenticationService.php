<?php

namespace App\Domain\Auth\Services;

use App\Domain\Auth\Contracts\LoginHistoryRepositoryInterface;
use App\Domain\Auth\Contracts\UserRepositoryInterface;
use App\Domain\Auth\Events\UserLoggedInEvent;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticationService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected LoginHistoryRepositoryInterface $loginHistoryRepository,
        protected AccountLockoutService $lockoutService
    ) {}

    public function login(string $email, string $password, bool $remember = false, ?string $ipAddress = null, ?string $userAgent = null): User
    {
        $user = $this->userRepository->findByEmail($email);

        if ($user && $user->isLocked()) {
            throw ValidationException::withMessages([
                'email' => 'Your account has been temporarily locked due to multiple failed login attempts. Please try again in 15 minutes or reset your password.',
            ]);
        }

        if ($user && $user->status === 'suspended') {
            throw ValidationException::withMessages([
                'email' => 'This account has been suspended by an administrator. Please contact support.',
            ]);
        }

        if ($user && $user->status === 'blocked') {
            throw ValidationException::withMessages([
                'email' => 'This account is permanently blocked due to a policy violation.',
            ]);
        }

        if (! Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            $this->lockoutService->handleFailedAttempt($email, $ipAddress, $userAgent);
            throw ValidationException::withMessages([
                'email' => 'The supplied credentials do not match our records.',
            ]);
        }

        /** @var User $authenticatedUser */
        $authenticatedUser = Auth::user();

        $this->lockoutService->clearAttempts($email);

        $loginHistory = $this->loginHistoryRepository->record([
            'user_id' => $authenticatedUser->id,
            'login_time' => now(),
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'login_status' => 'successful',
        ]);

        session(['login_history_id' => $loginHistory->id]);

        event(new UserLoggedInEvent($authenticatedUser, $ipAddress ?? '127.0.0.1'));

        return $authenticatedUser;
    }

    public function logout(): void
    {
        $loginHistoryId = session('login_history_id');
        if ($loginHistoryId) {
            $this->loginHistoryRepository->recordLogout($loginHistoryId);
        }

        Auth::guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();
    }
}
