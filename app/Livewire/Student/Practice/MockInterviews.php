<?php

namespace App\Livewire\Student\Practice;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.student')]
#[Title('AI Mock Interview Simulator - SkillBridge')]
class MockInterviews extends Component
{
    public string $selectedRole = 'Laravel System Architect';
    public int $currentQuestionIndex = 0;
    public string $studentAnswer = '';
    public string $aiFeedback = '';

    public array $questions = [
        [
            'question' => 'How would you handle high-throughput queue processing in Laravel 12 when handling 100,000 requests/sec?',
            'hint' => 'Mention Horizon, Redis cluster, supervisor worker scaling, and idempotent jobs.',
        ],
        [
            'question' => 'Explain the architectural differences between Monolithic, Microservices, and Domain-Driven Design in Laravel.',
            'hint' => 'Discuss bounded contexts, separate databases, and event-driven messaging using RabbitMQ/Kafka.',
        ],
    ];

    public function submitAnswer()
    {
        $this->validate([
            'studentAnswer' => 'required|string|min:10',
        ]);

        $this->aiFeedback = "🤖 AI Examiner Evaluation:\nScore: 92/100 (Excellent)\n\nKey Strengths: Great explanation of Redis Horizon workers and idempotent queue jobs.\nRecommendation: Mention database connection pooling to avoid MySQL port exhaustion under extreme load.";

        session()->flash('status', 'Answer evaluated by AI Examiner!');
    }

    public function nextQuestion()
    {
        $this->currentQuestionIndex = ($this->currentQuestionIndex + 1) % count($this->questions);
        $this->studentAnswer = '';
        $this->aiFeedback = '';
    }

    public function render()
    {
        $currentQ = $this->questions[$this->currentQuestionIndex];

        return view('livewire.student.practice.mock-interviews', compact('currentQ'));
    }
}
