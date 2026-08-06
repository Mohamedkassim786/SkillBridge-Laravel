<?php

namespace App\Livewire\Student\Practice;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.student')]
#[Title('Skill Assessment Tests - SkillBridge')]
class SkillAssessments extends Component
{
    public string $selectedCategory = 'PHP 8.3 & Laravel 12';
    public ?int $score = null;
    public array $userAnswers = [];

    public array $questions = [
        [
            'id' => 1,
            'question' => 'What is the primary benefit of using Laravel 12 Concurrency::run()?',
            'options' => [
                'A' => 'Allows executing multiple asynchronous tasks in parallel',
                'B' => 'Compiles Blade views to HTML faster',
                'C' => 'Connects to SQLite databases synchronously',
                'D' => 'Automatically clears route cache',
            ],
            'correct' => 'A',
        ],
        [
            'id' => 2,
            'question' => 'Which Livewire 3 directive handles instant button loading state spinners?',
            'options' => [
                'A' => 'wire:click',
                'B' => 'wire:loading',
                'C' => 'wire:model.live',
                'D' => 'wire:navigate',
            ],
            'correct' => 'B',
        ],
    ];

    public function submitQuiz()
    {
        $correctCount = 0;
        foreach ($this->questions as $q) {
            $userAns = $this->userAnswers[$q['id']] ?? null;
            if ($userAns === $q['correct']) {
                $correctCount++;
            }
        }

        $this->score = (int) (($correctCount / count($this->questions)) * 100);
        session()->flash('status', "Skill Assessment Completed! You scored {$this->score}%! 🎉");
    }

    public function render()
    {
        return view('livewire.student.practice.skill-assessments');
    }
}
