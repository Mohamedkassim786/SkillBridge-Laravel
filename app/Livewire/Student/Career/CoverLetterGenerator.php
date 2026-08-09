<?php

namespace App\Livewire\Student\Career;

use App\Domain\Ai\Common\NvidiaRagAiAgentService;
use App\Domain\Ai\CoverLetter\CoverLetterGeneratorService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.student')]
#[Title('NVIDIA AI Cover Letter Generator - SkillBridge')]
class CoverLetterGenerator extends Component
{
    // Applicant & Target Details
    public string $fullName = '';
    public string $email = '';
    public string $phone = '';
    public string $location = '';

    public string $targetRole = '';
    public string $companyName = '';
    public string $hiringManager = 'Hiring Manager / Talent Acquisition Team';
    public string $skillsInput = '';
    public string $coreHighlights = '';
    public string $toneStyle = 'Professional, confident, concise';

    // Generated Output State
    public string $coverLetterOutput = '';
    public array $keyHighlights = [];
    public bool $isAiGenerated = false;

    public function mount()
    {
        $user = auth()->user();
        if ($user) {
            $this->fullName = $user->name;
            $this->email = $user->email;
        }
    }

    /**
     * Called by Livewire when any property changes — sync session for PDF download.
     */
    public function updated($propertyName)
    {
        $this->syncCoverLetterSession();
    }

    /**
     * Sync cover letter data to session for PDF download controller.
     */
    protected function syncCoverLetterSession(): void
    {
        if (empty($this->coverLetterOutput)) return;

        session([
            'generated_cover_letter' => [
                'name' => $this->fullName,
                'email' => $this->email,
                'phone' => $this->phone,
                'location' => $this->location,
                'target_role' => $this->targetRole,
                'company_name' => $this->companyName,
                'hiring_manager' => $this->hiringManager,
                'letter_body' => $this->coverLetterOutput,
                'highlights' => $this->keyHighlights,
                'date' => date('F d, Y'),
            ]
        ]);
    }

    /**
     * Generate cover letter using NVIDIA NIM AI.
     * Fixed: optional DI parameter with container fallback for wire:click compatibility.
     */
    public function generateCoverLetter(?NvidiaRagAiAgentService $nvidiaAgent = null): void
    {
        @set_time_limit(30);
        $nvidiaAgent = $nvidiaAgent ?? app(NvidiaRagAiAgentService::class);

        $result = $nvidiaAgent->generateCoverLetter(
            resumeText: $this->coreHighlights,
            jobTitle: $this->targetRole ?: 'Software Developer',
            companyName: $this->companyName ?: 'Target Company',
            candidateName: $this->fullName,
            skills: $this->skillsInput,
            experience: $this->coreHighlights,
            tone: $this->toneStyle
        );

        $this->coverLetterOutput = $result['cover_letter'] ?? '';
        $this->keyHighlights = $result['key_highlights'] ?? [
            "Proficiency in {$this->skillsInput}",
            "Hands-on experience building production software systems",
            "Strong alignment with modern architecture best practices",
        ];
        $this->isAiGenerated = true;

        // Sync to session for PDF download
        $this->syncCoverLetterSession();

        session()->flash('status', '✨ NVIDIA AI Cover Letter generated successfully!');
    }

    public function render()
    {
        return view('livewire.student.career.cover-letter-generator');
    }
}
