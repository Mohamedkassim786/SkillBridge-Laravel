<?php

namespace App\Livewire\Public;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.public')]
#[Title('About Us - SkillBridge LMS')]
class About extends Component
{
    public function render()
    {
        return view('livewire.public.about');
    }
}
