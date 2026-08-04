<?php

namespace App\Livewire\Auth;

use App\Domain\Auth\Services\StudentRegistrationService;
use App\Rules\StrongPasswordRule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.auth')]
#[Title('Student Registration - SkillBridge')]
class Register extends Component
{
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $phone = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $terms = false;

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'confirmed', new StrongPasswordRule()],
            'terms' => ['accepted'],
        ];
    }

    public function register(StudentRegistrationService $registrationService)
    {
        $this->validate();

        $user = $registrationService->registerStudent([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password,
        ]);

        return redirect()->route('verification.notice')
            ->with('status', 'Registration successful! A verification email has been sent to '.$user->email);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
