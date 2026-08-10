<?php

namespace App\Domain\Ai\CoverLetter;

use App\Domain\Ai\Common\NvidiaRagAiAgentService;
use App\Domain\Ai\Common\RagKnowledgeService;

class CoverLetterGeneratorService
{
    protected NvidiaRagAiAgentService $aiAgentService;
    protected RagKnowledgeService $ragKnowledgeService;
    protected CoverLetterContentNormalizer $normalizer;

    public function __construct(
        NvidiaRagAiAgentService $aiAgentService,
        RagKnowledgeService $ragKnowledgeService,
        ?CoverLetterContentNormalizer $normalizer = null
    ) {
        $this->aiAgentService = $aiAgentService;
        $this->ragKnowledgeService = $ragKnowledgeService;
        $this->normalizer = $normalizer ?? new CoverLetterContentNormalizer();
    }

    /**
     * AI Cover Letter Generator Engine
     */
    public function generateCoverLetter(array $userInput): array
    {
        // 1. Input Normalization
        $role = $this->normalizer->normalizeTargetRole($userInput['targetRole'] ?? '');
        $company = $this->normalizer->normalizeCompanyName($userInput['companyName'] ?? '');
        $candidateName = trim($userInput['fullName'] ?? 'Candidate');
        $location = trim($userInput['location'] ?? '');
        $hiringManager = trim($userInput['hiringManager'] ?? '') ?: 'Hiring Manager';
        $tone = trim($userInput['toneStyle'] ?? 'Professional, confident, concise');
        $skillsInput = trim($userInput['skillsInput'] ?? '');
        $projectsInput = trim($userInput['coreHighlights'] ?? '');

        $normalizedSkills = $this->normalizer->parseNormalizedSkills($skillsInput);
        $naturalSkillsText = $this->normalizer->formatSkillsAsNaturalSentence($normalizedSkills);

        $ragContext = $this->ragKnowledgeService->retrieveContext(implode(' ', $normalizedSkills) . ' ' . $role);

        // 2. Structured System Prompt enforcing strict JSON output
        $systemPrompt = <<<'PROMPT'
You are an expert Certified Professional Resume Writer (CPRW) and AI Cover Letter Editor.

Write a truthful, personalized, professional cover letter for the candidate tailored to the target company and role.

CRITICAL EDITING CONSTRAINTS (MUST FOLLOW):
1. TRUTHFUL & GROUNDED: Use ONLY skills, projects, and facts provided by the user. NEVER invent years of experience, production scale, revenue, percentages, client names, certifications, or leadership responsibilities not provided.
2. NO RAW SKILLS DUMPS: Never output raw concatenated skill strings like "reactjs,nodejs,python". Always use proper technology names naturally in sentences (e.g., "experience with React.js, Node.js, and MongoDB").
3. ENTRY-LEVEL APPROPRIATE: If the candidate is a student/intern/fresher, use appropriate language ("academic and project experience", "hands-on exposure", "practical foundation in"). DO NOT claim "proven expertise", "extensive industry experience", or "measurable results" unless explicitly supported by data.
4. COMPANY NAME: Mention the company name naturally 1–2 times. Do not invent company products, culture, or values not provided.
5. LENGTH: 250–400 words (3–4 paragraphs).

Return ONLY valid JSON matching this exact schema:
{
    "target_role": "Normalized Role Title",
    "company": "Company Name",
    "greeting": "Dear Hiring Manager,",
    "opening": "First paragraph (introduction, target role, company interest, candidate identity)",
    "experience_paragraph": "Second paragraph (relevant project work, internships, technical skills integrated naturally)",
    "fit_paragraph": "Third paragraph (value proposition, practical problem solving, interest in contributing)",
    "closing_paragraph": "Fourth paragraph (thanking for consideration, call to action)",
    "core_qualifications": [
        "First grounded qualification bullet",
        "Second grounded qualification bullet",
        "Third grounded qualification bullet"
    ],
    "signature": "Candidate Name"
}
PROMPT;

        $userPrompt = <<<PROMPT
Target Job Title: {$role}
Target Company: {$company}
Hiring Manager: {$hiringManager}
Applicant Name: {$candidateName}
Applicant Location: {$location}
Technical Skills: {$naturalSkillsText}
Projects & Achievements: {$projectsInput}
Writing Tone: {$tone}

Domain Context: {$ragContext['retrieved_docs']}

Write a truthful, professional cover letter and return ONLY valid JSON matching the schema.
PROMPT;

        try {
            $apiResult = $this->aiAgentService->callNvidiaNim([
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $userPrompt],
            ], 0.2, 1400, 12);

            if ($apiResult && is_array($apiResult) && !empty($apiResult['opening'])) {
                // Sanitize AI outputs to ensure zero raw skill dumps or exaggerated claims
                $opening = $this->normalizer->sanitizeText($apiResult['opening'] ?? '', $userInput);
                $experienceP = $this->normalizer->sanitizeText($apiResult['experience_paragraph'] ?? '', $userInput);
                $fitP = $this->normalizer->sanitizeText($apiResult['fit_paragraph'] ?? '', $userInput);
                $closingP = $this->normalizer->sanitizeText($apiResult['closing_paragraph'] ?? '', $userInput);

                $qualifications = [];
                if (!empty($apiResult['core_qualifications']) && is_array($apiResult['core_qualifications'])) {
                    foreach ($apiResult['core_qualifications'] as $q) {
                        $cleanQ = $this->normalizer->sanitizeText((string) $q, $userInput);
                        if (!empty($cleanQ)) $qualifications[] = $cleanQ;
                    }
                }

                $greeting = $apiResult['greeting'] ?? "Dear {$hiringManager},";
                $signature = $apiResult['signature'] ?? $candidateName;

                $fullLetterBody = "{$greeting}\n\n{$opening}\n\n{$experienceP}\n\n{$fitP}\n\n{$closingP}\n\nSincerely,\n{$signature}";

                return [
                    'target_role' => $role,
                    'company' => $company,
                    'hiring_manager' => $hiringManager,
                    'greeting' => $greeting,
                    'opening' => $opening,
                    'experience_paragraph' => $experienceP,
                    'fit_paragraph' => $fitP,
                    'closing_paragraph' => $closingP,
                    'core_qualifications' => array_slice($qualifications, 0, 4),
                    'signature' => $signature,
                    'full_letter_body' => $fullLetterBody,
                    'cover_letter' => $fullLetterBody, // Backward compatibility
                    'key_highlights' => array_slice($qualifications, 0, 4), // Backward compatibility
                ];
            }
        } catch (\Throwable $e) {
            logger()->error('Cover Letter AI Generation Error: ' . $e->getMessage());
        }

        // 3. Fallback Generation
        $fallback = $this->normalizer->buildStructuredFallback($userInput);
        $fallback['cover_letter'] = $fallback['full_letter_body'];
        $fallback['key_highlights'] = $fallback['core_qualifications'];
        return $fallback;
    }
}
