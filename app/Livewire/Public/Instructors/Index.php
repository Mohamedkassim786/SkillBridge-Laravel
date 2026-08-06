<?php

namespace App\Livewire\Public\Instructors;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.public')]
#[Title('Instructors & Architects - SkillBridge LMS')]
class Index extends Component
{
    public function render()
    {
        $instructors = User::role(['staff', 'admin'])->get();

        return view('livewire.public.instructors.index', compact('instructors'));
    }
}
