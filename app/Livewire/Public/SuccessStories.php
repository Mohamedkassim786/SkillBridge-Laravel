<?php

namespace App\Livewire\Public;

use App\Models\SuccessStory;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.public')]
#[Title('Success Stories & Student Outcomes - SkillBridge LMS')]
class SuccessStories extends Component
{
    public function render()
    {
        $stories = SuccessStory::all();

        return view('livewire.public.success-stories', compact('stories'));
    }
}
