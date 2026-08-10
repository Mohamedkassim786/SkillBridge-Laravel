<?php

namespace App\Livewire\Student\Career;

use App\Domain\Ai\Common\NvidiaRagAiAgentService;
use App\Domain\Ai\Resume\ResumeSuggestionService;
use App\Models\UserResume;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.student')]
#[Title('NVIDIA AI Full ATS Resume Builder - SkillBridge')]
class ResumeBuilder extends Component
{
    // Contact & Profile Header Inputs
    public string $fullName = '';
    public string $headlineTitle = '';
    public string $phone = '';
    public string $email = '';
    public string $location = '';
    public string $linkedin = '';
    public string $github = '';
    public string $portfolio = '';

    // Section Inputs
    public string $experienceSummary = '';
    public string $educationRaw = '';
    public string $skillsInput = '';
    public string $workExperienceRaw = '';
    public string $projectsRaw = '';
    public string $certificationsRaw = '';
    public string $softSkillsInput = '';

    public string $targetJobDescription = '';

    // Generated Resume State
    public ?array $generatedResume = null;
    public int $atsScore = 0;
    public array $matchedKeywords = [];
    public array $missingKeywords = [];

    public array $suggestedImprovements = [];
    public array $suggestedSkills = [];
    public array $missingRequiredFields = [];

    // Interactive Field Suggestions State
    public array $fieldSuggestions = [];
    public array $appliedSuggestions = [];
    public array $previousFieldValues = [];
    public array $qualityChecklist = [];

    // Tracks whether current preview is AI-enhanced or raw input
    public bool $isAiGenerated = false;

    // Cover Letter Output State
    public string $coverLetterOutput = '';

    public function mount()
    {
        $user = auth()->user();
        if ($user) {
            $this->fullName = $user->name;
            $this->email = $user->email;
        }

        // Try to load previously saved resume from DB
        $this->loadSavedResume();

        // Build initial preview from raw input
        $this->syncResumeSession();

        // Initial Quality Checklist
        $this->updateQualityChecklist();
    }

    /**
     * Load previously saved resume data from the database.
     */
    protected function loadSavedResume(): void
    {
        $user = auth()->user();
        if (!$user) return;

        $savedResume = UserResume::where('user_id', $user->id)->where('is_default', true)->first();
        if ($savedResume && $savedResume->parsed_text) {
            $decoded = json_decode($savedResume->parsed_text, true);
            if (is_array($decoded) && !empty($decoded['name'])) {
                // Restore form fields from saved data
                $this->fullName = $decoded['name'] ?? $this->fullName;
                $this->headlineTitle = $decoded['headline'] ?? $this->headlineTitle;
                $this->phone = $decoded['phone'] ?? $this->phone;
                $this->email = $decoded['email'] ?? $this->email;
                $this->location = $decoded['location'] ?? $this->location;
                $this->linkedin = $decoded['linkedin'] ?? $this->linkedin;
                $this->github = $decoded['github'] ?? $this->github;
                $this->portfolio = $decoded['portfolio'] ?? $this->portfolio;

                if (!empty($decoded['work_experience_raw'])) {
                    $this->workExperienceRaw = $decoded['work_experience_raw'];
                } elseif (!empty($decoded['work_experience']) && is_array($decoded['work_experience'])) {
                    $lines = [];
                    foreach ($decoded['work_experience'] as $we) {
                        $lines[] = ($we['title'] ?? '') . ' — ' . ($we['company'] ?? '') . ' | ' . ($we['period'] ?? '');
                        if (!empty($we['bullets'])) {
                            foreach ($we['bullets'] as $b) {
                                $lines[] = "- {$b}";
                            }
                        }
                    }
                    $this->workExperienceRaw = implode("\n", $lines);
                }
                if (!empty($decoded['professional_summary'])) {
                    $this->experienceSummary = $decoded['professional_summary'];
                }
                if (!empty($decoded['ats_score'])) {
                    $this->atsScore = (int) $decoded['ats_score'];
                }
                if (!empty($decoded['matched_keywords'])) {
                    $this->matchedKeywords = $decoded['matched_keywords'];
                }
                if (!empty($decoded['missing_keywords'])) {
                    $this->missingKeywords = $decoded['missing_keywords'];
                }
                if (!empty($decoded['suggested_improvements'])) {
                    $this->suggestedImprovements = $decoded['suggested_improvements'];
                }
                if (!empty($decoded['suggested_skills'])) {
                    $this->suggestedSkills = $decoded['suggested_skills'];
                }
            }
        }
    }

    /**
     * Called automatically by Livewire whenever any property changes.
     */
    public function updated($propertyName)
    {
        $this->isAiGenerated = false;
        $this->missingRequiredFields = [];
        $this->syncResumeSession();
        $this->updateQualityChecklist();
    }

    /**
     * Update health status of each resume section for the AI Quality Panel.
     */
    protected function updateQualityChecklist(): void
    {
        $this->qualityChecklist = [
            'contact' => !empty($this->fullName) && !empty($this->email) && !empty($this->phone),
            'education' => !empty($this->educationRaw),
            'summary' => !empty($this->experienceSummary) && strlen($this->experienceSummary) >= 50 && !str_contains(strtolower($this->experienceSummary), 'fresher'),
            'skills' => !empty($this->skillsInput),
            'projects' => !empty($this->projectsRaw),
        ];
    }

    /**
     * Validate important required fields before AI functions execute.
     */
    protected function validateImportantFields(): bool
    {
        $this->missingRequiredFields = [];

        if (empty(trim($this->fullName))) {
            $this->missingRequiredFields[] = 'Full Name';
        }
        if (empty(trim($this->phone))) {
            $this->missingRequiredFields[] = 'Phone Number';
        }
        if (empty(trim($this->email))) {
            $this->missingRequiredFields[] = 'Email Address';
        }
        if (empty(trim($this->educationRaw))) {
            $this->missingRequiredFields[] = 'Education Details';
        }
        if (empty(trim($this->skillsInput)) && empty(trim($this->projectsRaw))) {
            $this->missingRequiredFields[] = 'Technical Skills or Projects';
        }

        if (count($this->missingRequiredFields) > 0) {
            session()->flash('error', '⚠️ Please fill in all required important fields first: ' . implode(', ', $this->missingRequiredFields));
            return false;
        }

        return true;
    }

    /**
     * Parse raw textarea inputs into structured resume data for live preview.
     */
    public function syncResumeSession(): void
    {
        // Parse Work Experience dynamically from workExperienceRaw textarea using ResumeExperienceParser
        $expParser = app(\App\Domain\Ai\Resume\ResumeExperienceParser::class);
        $workBlocks = $expParser->parseWorkExperience($this->workExperienceRaw);
        $projectBlocks = $expParser->parseProjects($this->projectsRaw);

        // Parse Education dynamically from educationRaw textarea
        $eduBlocks = [];
        if (!empty(trim($this->educationRaw))) {
            if (str_contains($this->educationRaw, '|') || str_contains($this->educationRaw, '–')) {
                $eduLines = array_values(array_filter(array_map('trim', explode("\n", $this->educationRaw))));
                foreach ($eduLines as $line) {
                    $parts = preg_split('/\s*[\|–—]\s*/', $line);
                    $eduBlocks[] = [
                        'degree' => trim($parts[0] ?? $line),
                        'institution' => trim($parts[1] ?? ''),
                        'cgpa' => trim($parts[2] ?? ''),
                        'year' => trim($parts[3] ?? ''),
                    ];
                }
            } else {
                $lines = array_values(array_filter(array_map('trim', explode("\n", $this->educationRaw))));
                $degree = '';
                $institution = '';
                $cgpa = '';
                $year = '';

                foreach ($lines as $line) {
                    $lineLower = strtolower($line);
                    if (str_contains($lineLower, 'b.e') || str_contains($lineLower, 'b e') || str_contains($lineLower, 'btech') || str_contains($lineLower, 'b.tech') || str_contains($lineLower, 'b.des') || str_contains($lineLower, 'degree') || str_contains($lineLower, 'bachelor') || str_contains($lineLower, 'master') || str_contains($lineLower, 'm.e') || str_contains($lineLower, 'mtech')) {
                        $degree = $line;
                    } elseif (str_contains($lineLower, 'cgpa') || str_contains($lineLower, 'gpa') || preg_match('/\b\d\.\d\b/', $line)) {
                        $cgpa = $line;
                    } elseif (preg_match('/\b(20\d\d)\b/', $line, $ym)) {
                        $year = "Expected: {$ym[1]}";
                    } else {
                        $institution = $line;
                    }
                }

                if (!empty($degree) || !empty($institution)) {
                    $eduBlocks[] = [
                        'degree' => $degree ?: 'Bachelor of Engineering – Computer Science and Engineering',
                        'institution' => $institution ?: 'Engineering College',
                        'cgpa' => $cgpa,
                        'year' => $year ?: '2026',
                    ];
                }
            }
        }

        // Parse Technical Skills dynamically from skillsInput textarea
        $skillLines = array_values(array_filter(array_map('trim', explode("\n", $this->skillsInput))));
        $skillsMap = [];
        foreach ($skillLines as $line) {
            if (str_contains($line, ':')) {
                $parts = explode(':', $line, 2);
                $skillsMap[trim($parts[0])] = trim($parts[1]);
            } else {
                $skillsMap['Skills'] = ($skillsMap['Skills'] ?? '') . ($skillsMap['Skills'] ?? '' ? ', ' : '') . $line;
            }
        }

        // Parse Certifications dynamically
        $certList = array_values(array_filter(array_map('trim', explode("\n", $this->certificationsRaw))));

        // Parse Soft Skills dynamically
        $softList = array_values(array_filter(array_map('trim', explode(',', $this->softSkillsInput))));

        $this->generatedResume = [
            'name' => $this->fullName,
            'headline' => $this->headlineTitle,
            'phone' => $this->phone,
            'email' => $this->email,
            'location' => $this->location,
            'linkedin' => $this->linkedin,
            'github' => $this->github,
            'portfolio' => $this->portfolio,
            'ats_score' => $this->atsScore,
            'professional_summary' => $this->experienceSummary,
            'education' => $eduBlocks,
            'technical_skills' => $skillsMap,
            'work_experience' => $workBlocks,
            'work_experience_raw' => $this->workExperienceRaw,
            'projects' => $projectBlocks,
            'certifications' => $certList,
            'soft_skills' => $softList,
            'matched_keywords' => $this->matchedKeywords,
            'missing_keywords' => $this->missingKeywords,
            'suggested_improvements' => $this->suggestedImprovements,
            'suggested_skills' => $this->suggestedSkills,
        ];

        // Normalize generated resume structure
        $normalizer = app(\App\Domain\Ai\Resume\ResumeNormalizer::class);
        $this->generatedResume = $normalizer->normalize($this->generatedResume);

        // Store updated payload into session for PDF Controller download
        session(['generated_ats_resume' => $this->generatedResume]);

        // Save updated resume to DB
        $this->persistToDatabase();
    }

    /**
     * Persist current resume data to the database.
     */
    protected function persistToDatabase(): void
    {
        $user = auth()->user();
        if (!$user || !$this->generatedResume) return;

        UserResume::updateOrCreate(
            ['user_id' => $user->id, 'is_default' => true],
            [
                'title' => ($this->fullName ?: 'My') . ' - ATS Resume.pdf',
                'file_path' => 'resumes/generated_resume.pdf',
                'parsed_text' => json_encode($this->generatedResume),
                'parsed_skills' => array_values(array_filter(array_map('trim', explode(',', $this->skillsInput)))),
            ]
        );
    }

    /**
     * BUTTON 1: Get AI Field-by-Field Suggestions & Recommendations.
     */
    public function getAiSuggestions(?ResumeSuggestionService $suggestionService = null, ?NvidiaRagAiAgentService $nvidiaAgent = null): void
    {
        $this->updateQualityChecklist();

        @set_time_limit(60);
        @ini_set('max_execution_time', '60');

        $suggestionService = $suggestionService ?? app(ResumeSuggestionService::class);
        $ragService = app(\App\Domain\Ai\Services\RagKnowledgeService::class);

        $input = [
            'fullName' => $this->fullName,
            'headlineTitle' => $this->headlineTitle,
            'phone' => $this->phone,
            'email' => $this->email,
            'location' => $this->location,
            'linkedin' => $this->linkedin,
            'github' => $this->github,
            'portfolio' => $this->portfolio,
            'experienceSummary' => $this->experienceSummary,
            'educationRaw' => $this->educationRaw,
            'skillsInput' => $this->skillsInput,
            'workExperienceRaw' => $this->workExperienceRaw,
            'projectsRaw' => $this->projectsRaw,
            'certificationsRaw' => $this->certificationsRaw,
            'softSkillsInput' => $this->softSkillsInput,
            'targetJobDescription' => $this->targetJobDescription,
        ];

        // 1 Single Fast AI Call for Field-by-Field suggestions
        $rawSuggestions = $suggestionService->analyzeAllFields($input);

        // Sanitize every suggestion field to string and map to Livewire field properties
        $this->fieldSuggestions = [];
        foreach ($rawSuggestions as $k => $item) {
            if (!is_array($item)) continue;
            
            $fieldKey = match ($k) {
                'headline', 'headline_title', 'headlineTitle' => 'headlineTitle',
                'professional_summary', 'summary', 'experienceSummary' => 'experienceSummary',
                'technical_skills', 'skills', 'skillsInput' => 'skillsInput',
                'work_experience', 'work_experience_raw', 'workExperienceRaw' => 'workExperienceRaw',
                'projects', 'projects_raw', 'projectsRaw' => 'projectsRaw',
                'certifications', 'certifications_raw', 'certificationsRaw' => 'certificationsRaw',
                'soft_skills', 'soft_skills_input', 'softSkillsInput' => 'softSkillsInput',
                'name', 'full_name', 'fullName' => 'fullName',
                'education', 'education_raw', 'educationRaw' => 'educationRaw',
                'location', 'city_state' => 'location',
                default => $k,
            };

            $suggestedVal = $item['suggested'] ?? '';
            if (is_array($suggestedVal)) {
                $lines = [];
                foreach ($suggestedVal as $sk => $sv) {
                    $svStr = is_array($sv) ? implode(', ', $sv) : (string) $sv;
                    $lines[] = (is_string($sk) && !is_numeric($sk)) ? "{$sk}: {$svStr}" : $svStr;
                }
                $suggestedVal = implode("\n", $lines);
            }

            $reasonVal = $item['reason'] ?? '';
            if (is_array($reasonVal)) $reasonVal = implode(' ', array_map('strval', $reasonVal));

            $originalVal = $item['original'] ?? '';
            if (is_array($originalVal)) $originalVal = implode("\n", array_map('strval', $originalVal));

            $this->fieldSuggestions[$fieldKey] = [
                'field' => $fieldKey,
                'severity' => (string) ($item['severity'] ?? 'warning'),
                'title' => (string) ($item['title'] ?? 'Suggestion'),
                'reason' => (string) $reasonVal,
                'original' => (string) $originalVal,
                'suggested' => (string) $suggestedVal,
                'can_apply' => isset($item['can_apply']) ? (bool) $item['can_apply'] : (!empty($suggestedVal)),
            ];
        }

        // Instant RAG Keyword & ATS Score Calculation (0ms API delay!)
        $atsData = $ragService->generateAugmentedAtsScore($this->skillsInput, $this->targetJobDescription ?: 'Software Developer');
        $this->atsScore = $atsData['score'];
        $this->matchedKeywords = $atsData['matched_keywords'];
        $this->missingKeywords = $atsData['missing_keywords'];

        $this->updateQualityChecklist();

        session()->flash('status', '✨ AI analyzed all form fields! Review the inline suggestion cards below each field.');
    }

    /**
     * ONE-CLICK APPLY: Applies AI suggestion ONLY to the specified form field.
     */
    public function applySuggestion(string $field): void
    {
        if (!isset($this->fieldSuggestions[$field]) || empty($this->fieldSuggestions[$field]['suggested'])) {
            return;
        }

        // Store original value for 1-click Undo
        $this->previousFieldValues[$field] = is_array($this->$field ?? '') ? implode("\n", $this->$field) : ($this->$field ?? '');

        // Apply ONLY this field's suggested text (guaranteed string)
        $suggested = $this->fieldSuggestions[$field]['suggested'];
        if (is_array($suggested)) {
            $suggested = implode("\n", array_map('strval', $suggested));
        }

        $this->$field = (string) $suggested;
        $this->appliedSuggestions[$field] = true;

        // Immediately sync preview
        $this->syncResumeSession();
        $this->updateQualityChecklist();

        session()->flash('status', "✓ Applied AI suggestion to " . ucfirst($field) . "! Preview updated.");
    }

    /**
     * ONE-CLICK UNDO: Restores original text for the specified field.
     */
    public function undoSuggestion(string $field): void
    {
        if (isset($this->previousFieldValues[$field])) {
            $this->$field = $this->previousFieldValues[$field];
            unset($this->appliedSuggestions[$field]);
            unset($this->previousFieldValues[$field]);

            $this->syncResumeSession();
            $this->updateQualityChecklist();

            session()->flash('status', "↶ Restored original text for " . ucfirst($field) . ".");
        }
    }

    /**
     * Dismiss suggestion card for a specific field.
     */
    public function dismissSuggestion(string $field): void
    {
        unset($this->fieldSuggestions[$field]);
    }

    /**
     * ONE-CLICK APPLY ALL: Applies all non-conflicting field suggestions.
     */
    public function applyAllSuggestions(): void
    {
        foreach ($this->fieldSuggestions as $field => $data) {
            if (!empty($data['can_apply']) && !empty($data['suggested']) && isset($this->$field)) {
                $this->previousFieldValues[$field] = $this->$field;
                $this->$field = $data['suggested'];
                $this->appliedSuggestions[$field] = true;
            }
        }

        $this->syncResumeSession();
        $this->updateQualityChecklist();

        session()->flash('status', "✨ Applied all AI field suggestions! Resume preview updated.");
    }

    /**
     * BUTTON 2: Generate AI ATS Resume AND Automatically Download PDF.
     */
    public function generateFullAtsResume(?NvidiaRagAiAgentService $nvidiaAgent = null): void
    {
        if (!$this->validateImportantFields()) {
            return;
        }

        @set_time_limit(30);
        $nvidiaAgent = $nvidiaAgent ?? app(NvidiaRagAiAgentService::class);

        $input = [
            'fullName' => $this->fullName,
            'headlineTitle' => $this->headlineTitle,
            'phone' => $this->phone,
            'email' => $this->email,
            'location' => $this->location,
            'linkedin' => $this->linkedin,
            'github' => $this->github,
            'portfolio' => $this->portfolio,
            'experienceSummary' => $this->experienceSummary,
            'educationRaw' => $this->educationRaw,
            'skillsInput' => $this->skillsInput,
            'workExperienceRaw' => $this->workExperienceRaw,
            'projectsRaw' => $this->projectsRaw,
            'certificationsRaw' => $this->certificationsRaw,
            'softSkillsInput' => $this->softSkillsInput,
            'targetJobDescription' => $this->targetJobDescription,
        ];

        $aiResult = $nvidiaAgent->generateFullAtsResume($input);

        if (is_array($aiResult) && !empty($aiResult['professional_summary'])) {
            $this->generatedResume = $aiResult;
            $this->atsScore = (int) ($aiResult['ats_score'] ?? 0);
            $this->matchedKeywords = $aiResult['matched_keywords'] ?? [];
            $this->missingKeywords = $aiResult['missing_keywords'] ?? [];
            $this->suggestedImprovements = $aiResult['suggested_improvements'] ?? [];
            $this->suggestedSkills = $aiResult['suggested_skills'] ?? [];
            $this->isAiGenerated = true;

            if (empty($this->headlineTitle) && !empty($aiResult['headline'])) {
                $this->headlineTitle = $aiResult['headline'];
            }
            if (empty($this->experienceSummary) && !empty($aiResult['professional_summary'])) {
                $this->experienceSummary = $aiResult['professional_summary'];
            }

            session(['generated_ats_resume' => $this->generatedResume]);
            $this->persistToDatabase();

            session()->flash('status', '✨ ATS Resume generated! PDF download started automatically.');
        } else {
            $this->syncResumeSession();
            session()->flash('status', 'Resume generated! PDF download started automatically.');
        }

        // Trigger automatic PDF download in browser
        $this->js("window.open('" . route('student.career.resume.download-pdf') . "', '_blank');");
    }

    /**
     * Click-to-add a recommended certification into certificationsRaw field.
     */
    public function addCertificationToInput(string $certName): void
    {
        if (!str_contains(strtolower($this->certificationsRaw), strtolower($certName))) {
            $this->certificationsRaw .= ($this->certificationsRaw ? "\n" : '') . $certName;
            $this->syncResumeSession();
            session()->flash('status', "✨ Added '{$certName}' to your Certifications!");
        }
    }

    /**
     * Click-to-apply recommended soft skills into softSkillsInput field.
     */
    public function applySoftSkillsSuggestion(string $softSkills): void
    {
        $this->previousFieldValues['softSkillsInput'] = $this->softSkillsInput;
        $this->softSkillsInput = $softSkills;
        $this->appliedSuggestions['softSkillsInput'] = true;
        $this->syncResumeSession();
        session()->flash('status', "✓ Applied recommended Soft Skills!");
    }

    /**
     * Click-to-add a recommended skill into the candidate's skillsInput field.
     */
    public function addSuggestedSkill(string $skillName): void
    {
        if (!str_contains(strtolower($this->skillsInput), strtolower($skillName))) {
            $this->skillsInput .= ($this->skillsInput ? ', ' : '') . $skillName;
            $this->syncResumeSession();
            session()->flash('status', "✨ Added '{$skillName}' to your Technical Skills!");
        }
    }

    /**
     * Reset preview back to raw input parsing.
     */
    public function resetToRaw(): void
    {
        $this->isAiGenerated = false;
        $this->missingRequiredFields = [];
        $this->fieldSuggestions = [];
        $this->appliedSuggestions = [];
        $this->previousFieldValues = [];
        $this->syncResumeSession();
        $this->updateQualityChecklist();
        session()->flash('status', 'Preview reset to raw input data.');
    }

    /**
     * Generate a cover letter from the resume builder context.
     */
    public function generateCoverLetter(?NvidiaRagAiAgentService $nvidiaAgent = null): void
    {
        $nvidiaAgent = $nvidiaAgent ?? app(NvidiaRagAiAgentService::class);
        $result = $nvidiaAgent->generateCoverLetter(
            resumeText: "{$this->fullName}\n{$this->headlineTitle}\n{$this->experienceSummary}\nSkills: {$this->skillsInput}",
            jobTitle: 'Software Engineering Intern',
            companyName: 'Target Enterprise Company'
        );

        $this->coverLetterOutput = $result['cover_letter'] ?? '';

        session()->flash('status', 'NVIDIA AI Cover Letter generated successfully!');
    }

    public function render()
    {
        return view('livewire.student.career.resume-builder', get_object_vars($this));
    }
}
