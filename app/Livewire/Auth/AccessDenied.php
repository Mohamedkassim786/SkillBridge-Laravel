<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.auth')]
#[Title('Access Denied (403) - SkillBridge')]
class AccessDenied extends Component
{
    public function render()
    {
        return view('errors.403');
    }
}
