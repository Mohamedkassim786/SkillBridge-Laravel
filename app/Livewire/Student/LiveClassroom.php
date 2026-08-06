<?php

namespace App\Livewire\Student;

use App\Models\PublicEvent;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Live Classroom - SkillBridge')]
class LiveClassroom extends Component
{
    public ?string $classId = null;
    public ?PublicEvent $event = null;

    // Chat messages
    public array $chatMessages = [];
    public string $newMessage = '';

    public function mount(?string $classId = null)
    {
        $this->classId = $classId;

        if ($this->classId) {
            $this->event = PublicEvent::find($this->classId);
        }

        if (! $this->event) {
            $this->event = PublicEvent::where('is_upcoming', true)->first();
        }

        $this->chatMessages = [
            ['user' => 'Dr. Marcus Vance', 'time' => '14:00', 'message' => 'Welcome everyone to today\'s Live Masterclass! Feel free to ask questions in the Q&A feed.', 'is_instructor' => true],
            ['user' => 'Priya Sharma', 'time' => '14:02', 'message' => 'Hello Instructor! Super excited for the Laravel 12 Domain Architecture session.', 'is_instructor' => false],
            ['user' => 'Demo Student', 'time' => '14:05', 'message' => 'Are today\'s slides and repository code available for download?', 'is_instructor' => false],
        ];
    }

    public function sendMessage()
    {
        $this->validate([
            'newMessage' => 'required|string|max:500',
        ]);

        $user = auth()->user();
        $isInstructor = $user?->hasRole(['staff', 'trainer', 'admin', 'super_admin']) ?? false;

        $this->chatMessages[] = [
            'user' => $user?->name ?? 'User',
            'time' => date('H:i'),
            'message' => $this->newMessage,
            'is_instructor' => $isInstructor,
        ];

        $this->newMessage = '';
    }

    public function render()
    {
        $user = auth()->user();
        $layout = ($user && $user->hasRole(['staff', 'trainer', 'admin', 'super_admin'])) 
            ? 'components.layouts.staff' 
            : 'components.layouts.student';

        return view('livewire.student.live-classroom')->layout($layout);
    }
}
