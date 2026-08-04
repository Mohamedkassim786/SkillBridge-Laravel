<?php

namespace App\Livewire\Auth;

use App\Domain\Auth\Services\AuthenticationService;
use App\Domain\Auth\Services\RoleRedirectionService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.auth')]
#[Title('Sign In - SkillBridge')]
class Login extends Component
{
    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    public function authenticate(AuthenticationService $authService, RoleRedirectionService $roleService)
    {
        $this->validate();

        $user = $authService->login(
            email: $this->email,
            password: $this->password,
            remember: $this->remember,
            ipAddress: request()->ip(),
            userAgent: request()->userAgent()
        );

        session()->regenerate();

        if (! $user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        if (($user->profile?->profile_completion_percentage ?? 0) < 50 && $user->hasRole('student')) {
            return redirect()->route('profile.complete');
        }

        return redirect()->intended($roleService->getRedirectPath($user));
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
