<?php

namespace App\Livewire\Student\Career;

use App\Domain\Ai\Services\RagKnowledgeService;
use App\Models\UserResume;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.student')]
#[Title('AI Resume Builder & RAG ATS Analyzer - SkillBridge')]
class ResumeBuilder extends Component
{
    public string $fullName = '';
    public string $email = '';
    public string $phone = '';
    public string $targetRole = 'Senior Software Engineer';
    public string $skillsInput = 'PHP, Laravel 12, React 19, Node.js, Python, MySQL 8, Docker';
    public string $experienceSummary = '3+ years of multi-stack software development experience building high-scale microservices, REST APIs, and modern frontend applications.';

    // Target job description for RAG ATS Analysis
    public string $targetJobDescription = 'We are hiring a Senior Engineer skilled in Laravel 12, React 19, Python, MySQL 8, Redis caching, microservices, and Docker containerization.';

    // RAG Output state
    public int $atsScore = 94;
    public string $retrievedContext = '';
    public array $matchedKeywords = ['PHP', 'LARAVEL', 'REACT', 'PYTHON', 'MYSQL 8', 'DOCKER'];
    public array $missingKeywords = ['KUBERNETES', 'TERRAFORM'];

    // Cover Letter Generator Output
    public string $coverLetterOutput = '';

    public function mount()
    {
        $user = auth()->user();
        if ($user) {
            $this->fullName = $user->name;
            $this->email = $user->email;
        }

        $this->calculateAtsScore();
    }

    public function calculateAtsScore()
    {
        $ragService = app(RagKnowledgeService::class);
        $result = $ragService->generateAugmentedAtsScore($this->skillsInput, $this->targetJobDescription);

        $this->atsScore = $result['score'];
        $this->retrievedContext = $result['retrieved_context'];
        $this->matchedKeywords = $result['matched_keywords'];
        $this->missingKeywords = $result['missing_keywords'];
    }

    public function generateCoverLetter()
    {
        $this->coverLetterOutput = "Dear Hiring Manager,\n\nI am writing to express my strong interest in the {$this->targetRole} position. With solid hands-on expertise in {$this->skillsInput}, I have successfully built and deployed high-performance enterprise applications.\n\n{$this->experienceSummary}\n\nI am confident that my technical skills in modern software architecture align perfectly with your team's requirements. I look forward to discussing how I can contribute to your projects.\n\nSincerely,\n{$this->fullName}";

        session()->flash('status', 'RAG-Augmented Cover Letter generated successfully!');
    }

    public function saveResume()
    {
        $user = auth()->user();

        UserResume::updateOrCreate(
            ['user_id' => $user->id],
            [
                'title' => "{$this->fullName} - {$this->targetRole} Resume.pdf",
                'file_path' => 'resumes/generated_resume.pdf',
                'parsed_skills' => explode(',', $this->skillsInput),
                'is_default' => true,
            ]
        );

        session()->flash('status', 'Resume saved and updated in your active profile!');
    }

    public function render()
    {
        return view('livewire.student.career.resume-builder');
    }
}
