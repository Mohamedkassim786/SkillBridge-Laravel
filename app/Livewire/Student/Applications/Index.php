<?php

namespace App\Livewire\Student\Applications;

use App\Models\JobApplication;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.student')]
#[Title('My Job Applications - SkillBridge')]
class Index extends Component
{
    public function render()
    {
        $applications = JobApplication::with(['jobPosting.company', 'resume'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.student.applications.index', compact('applications'));
    }
}
