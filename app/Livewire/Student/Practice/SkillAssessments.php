<?php

namespace App\Livewire\Student\Practice;

use App\Domain\Ai\Services\NvidiaRagAiAgentService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.student')]
#[Title('NVIDIA AI Adaptive Skill Assessment Tests - SkillBridge')]
class SkillAssessments extends Component
{
    // Setup & Configuration
    public string $skillTitle = 'PHP 8.3 & Laravel 12 Architecture';
    public int $questionCount = 5; // 5, 10, 15
    public string $difficultyLevel = 'intermediate'; // beginner, intermediate, advanced

    // State Flags
    public bool $quizStarted = false;
    public bool $quizCompleted = false;

    // Quiz Data
    public array $questions = [];
    public array $userAnswers = [];
    public ?int $score = null;

    // AI Evaluation & Connected Practice Loop
    public string $skillLevel = '';
    public array $strengths = [];
    public array $weaknesses = [];
    public array $learningRecommendations = [];
    public array $recommendedCodingChallenges = [];
    public array $recommendedMockInterviews = [];

    public function startAssessment(NvidiaRagAiAgentService $nvidiaAgent)
    {
        $this->validate([
            'skillTitle' => 'required|string|min:3',
            'questionCount' => 'required|integer|in:5,10,15',
        ]);

        $this->questions = $nvidiaAgent->generateDynamicSkillQuestions($this->skillTitle);
        $this->userAnswers = [];
        $this->score = null;
        $this->quizStarted = true;
        $this->quizCompleted = false;

        session()->flash('status', "NVIDIA AI generated {$this->questionCount} adaptive questions for: {$this->skillTitle}!");
    }

    public function submitQuiz(NvidiaRagAiAgentService $nvidiaAgent)
    {
        $correctCount = 0;
        foreach ($this->questions as $q) {
            $userAns = $this->userAnswers[$q['id']] ?? null;
            if ($userAns === $q['correct']) {
                $correctCount++;
            }
        }

        $total = max(count($this->questions), 1);
        $this->score = (int) round(($correctCount / $total) * 100);

        $result = $nvidiaAgent->evaluateSkillAssessment(
            skillDomain: $this->skillTitle,
            userAnswers: $this->userAnswers
        );

        $this->skillLevel = $result['skill_level'] ?? ($this->score >= 80 ? 'Advanced' : ($this->score >= 50 ? 'Intermediate' : 'Beginner'));
        $this->strengths = $result['strengths'] ?? ["Solid understanding of {$this->skillTitle} fundamentals"];
        $this->weaknesses = $result['weaknesses'] ?? ["Advanced concurrency and database query optimization"];
        $this->learningRecommendations = $result['learning_recommendations'] ?? ["Review Enterprise {$this->skillTitle} Architecture Patterns"];

        // Connected Practice Recommendations
        $this->recommendedCodingChallenges = [
            ['title' => "Two Sum & Hash Maps in {$this->skillTitle}", 'language' => 'PHP', 'difficulty' => 'Medium'],
            ['title' => "High-Throughput Database Indexing Query", 'language' => 'SQL', 'difficulty' => 'Hard'],
        ];

        $this->recommendedMockInterviews = [
            ['role' => "Senior {$this->skillTitle} Developer", 'type' => 'technical', 'focus' => 'System Design & REST APIs'],
            ['role' => "Lead Architect", 'type' => 'full_mock', 'focus' => 'STAR Behavioral & Architecture'],
        ];

        $this->quizCompleted = true;
        session()->flash('status', "Skill Assessment Completed! You scored {$this->score}% ({$this->skillLevel})! 🎉");
    }

    public function resetAssessment()
    {
        $this->quizStarted = false;
        $this->quizCompleted = false;
        $this->questions = [];
        $this->userAnswers = [];
        $this->score = null;
    }

    public function render()
    {
        return view('livewire.student.practice.skill-assessments');
    }
}
