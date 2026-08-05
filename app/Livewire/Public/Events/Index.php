<?php

namespace App\Livewire\Public\Events;

use App\Models\PublicEvent;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.public')]
#[Title('Live Events & Webinars - SkillBridge LMS')]
class Index extends Component
{
    public function render()
    {
        $events = PublicEvent::orderBy('starts_at', 'asc')->get();

        return view('livewire.public.events.index', compact('events'));
    }
}
