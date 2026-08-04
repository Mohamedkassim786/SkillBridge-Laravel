<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.auth')]
#[Title('Verification Failed - SkillBridge')]
class VerifyFailed extends Component
{
    public function render()
    {
        return view('livewire.auth.verify-failed');
    }
}
