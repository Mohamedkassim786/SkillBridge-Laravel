<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.auth')]
#[Title('Too Many Attempts - SkillBridge')]
class TooManyAttempts extends Component
{
    public function render()
    {
        return view('livewire.auth.too-many-attempts');
    }
}
