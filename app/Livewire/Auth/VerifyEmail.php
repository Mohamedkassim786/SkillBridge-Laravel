<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.auth')]
#[Title('Verify Email - SkillBridge')]
class VerifyEmail extends Component
{
    public function resendNotification()
    {
        if (auth()->user()) {
            auth()->user()->sendEmailVerificationNotification();
            session()->flash('status', 'A fresh verification link has been sent to your email address.');
        } else {
            session()->flash('warning', 'Please sign in first or check your email inbox.');
        }
    }

    public function render()
    {
        return view('livewire.auth.verify-email');
    }
}
