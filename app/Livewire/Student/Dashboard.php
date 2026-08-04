<?php

namespace App\Livewire\Student;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.student')]
#[Title('Student Dashboard - SkillBridge')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.student.dashboard');
    }
}
