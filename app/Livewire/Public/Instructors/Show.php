<?php

namespace App\Livewire\Public\Instructors;

use App\Models\Course;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.public')]
#[Title('Instructor Profile - SkillBridge LMS')]
class Show extends Component
{
    public string $id;

    public function mount(string $id)
    {
        $this->id = $id;
    }

    public function render()
    {
        $instructor = User::findOrFail($this->id);
        $courses = Course::where('trainer_id', $this->id)->get();

        return view('livewire.public.instructors.show', [
            'instructor' => $instructor,
            'courses' => $courses,
        ]);
    }
}
