<?php

namespace App\Livewire\Student\Career;

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

    // Generated Structured Output State
    public string $coverLetterOutput = '';
    public array $coverLetterData = [];
    public array $keyHighlights = [];
    public bool $isAiGenerated = false;

    public function mount()
    {
        $user = auth()->user();
        if ($user) {
            $this->fullName = $user->name;
            $this->email = $user->email;
        }

        // Restore existing session data if available
        $sessionData = session('generated_cover_letter');
        if (is_array($sessionData) && !empty($sessionData['letter_body'])) {
            $this->coverLetterOutput = $sessionData['letter_body'];
            $this->keyHighlights = $sessionData['highlights'] ?? [];
            $this->coverLetterData = $sessionData;
            $this->isAiGenerated = true;
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
            'generated_cover_letter' => array_merge([
                'name' => $this->fullName,
                'email' => $this->email,
                'phone' => $this->phone,
                'location' => $this->location,
                'target_role' => $this->targetRole,
                'company_name' => $this->companyName,
                'hiring_manager' => $this->hiringManager,
                'letter_body' => $this->coverLetterOutput,
                'highlights' => $this->keyHighlights,
                'signature' => $this->fullName,
                'date' => date('F d, Y'),
            ], $this->coverLetterData)
        ]);
    }

    /**
     * Validate required inputs before calling AI.
     */
    protected function validateInputs(): bool
    {
        $missing = [];
        if (empty(trim($this->targetRole))) $missing[] = 'Target Job Title';
        if (empty(trim($this->companyName))) $missing[] = 'Target Company Name';
        if (empty(trim($this->fullName))) $missing[] = 'Applicant Name';

        if (count($missing) > 0) {
            session()->flash('error', '⚠️ Please fill in all required fields first: ' . implode(', ', $missing));
            return false;
        }

        return true;
    }

    /**
     * Generate cover letter using NVIDIA NIM AI & CoverLetterGeneratorService.
     */
    public function generateCoverLetter(?CoverLetterGeneratorService $generatorService = null): void
    {
        if (!$this->validateInputs()) {
            return;
        }

        @set_time_limit(60);
        $generatorService = $generatorService ?? app(CoverLetterGeneratorService::class);

        $userInput = [
            'targetRole' => $this->targetRole,
            'companyName' => $this->companyName,
            'hiringManager' => $this->hiringManager,
            'fullName' => $this->fullName,
            'location' => $this->location,
            'skillsInput' => $this->skillsInput,
            'coreHighlights' => $this->coreHighlights,
            'toneStyle' => $this->toneStyle,
        ];

        $result = $generatorService->generateCoverLetter($userInput);

        $this->coverLetterData = $result;
        $this->coverLetterOutput = $result['full_letter_body'] ?? '';
        $this->keyHighlights = $result['core_qualifications'] ?? [];
        $this->isAiGenerated = true;

        // Sync to session for 1:1 matching PDF download
        $this->syncCoverLetterSession();

        session()->flash('status', '✨ Personalized AI Cover Letter generated successfully!');
    }

    public function render()
    {
        return view('livewire.student.career.cover-letter-generator', get_object_vars($this));
    }
}
