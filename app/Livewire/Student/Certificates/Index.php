<?php

namespace App\Livewire\Student\Certificates;

use App\Models\Certificate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.student')]
#[Title('My Certificates - SkillBridge')]
class Index extends Component
{
    public function render()
    {
        $certificates = Certificate::with(['courseVersion.course', 'user'])
            ->where('user_id', auth()->id())
            ->get();

        return view('livewire.student.certificates.index', compact('certificates'));
    }
}
