<?php

namespace App\Domain\Ai\CoverLetter;

use App\Domain\Ai\Common\NvidiaRagAiAgentService;
use App\Domain\Ai\Common\RagKnowledgeService;

class CoverLetterGeneratorService
{
    protected NvidiaRagAiAgentService $aiAgentService;
    protected RagKnowledgeService $ragKnowledgeService;

    public function __construct(NvidiaRagAiAgentService $aiAgentService, RagKnowledgeService $ragKnowledgeService)
    {
        $this->aiAgentService = $aiAgentService;
        $this->ragKnowledgeService = $ragKnowledgeService;
    }

    /**
     * AI Cover Letter Generator Engine
     */
    public function generateCoverLetter(
        string $resumeText,
        string $jobTitle,
        string $companyName,
        ?string $candidateName = null,
        ?string $skills = null,
        ?string $experience = null,
        ?string $tone = 'Professional, confident, concise'
    ): array {
        $candidateName = $candidateName ?: 'Candidate';
        $skills = $skills ?: 'Software Development';
        $experience = ltrim($experience ?: $resumeText, 'Built ');

        $ragContext = $this->ragKnowledgeService->retrieveContext($skills . ' ' . $jobTitle);

        $systemPrompt = <<<'PROMPT'
You are an Executive CPRW Cover Letter Writer specializing in technical roles.

Write a high-converting, personalized cover letter that:
1. Opens with a compelling hook mentioning the specific role and company
2. References the candidate's actual projects and skills (do NOT invent experience)
3. Connects the candidate's background to the job requirements
4. Closes with a confident call to action

RULES:
- Keep it to one page (3 short, impactful paragraphs)
- Use the candidate's actual skills and experience — do not fabricate
- Make it suitable for ATS parsing
- Match the requested tone

Reply ONLY in valid JSON with keys:
- "cover_letter" (string: 3 paragraphs separated by double newlines)
- "key_highlights" (array of 3 bullet strings summarizing core qualifications)
PROMPT;

        $userPrompt = <<<PROMPT
Job title: {$jobTitle}
Company: {$companyName}
Candidate name: {$candidateName}
Technical skills: {$skills}
Experience & projects: {$experience}
Writing tone: {$tone}

Domain Context: {$ragContext['retrieved_docs']}

Write a personalized cover letter and return as JSON.
PROMPT;

        $apiResult = $this->aiAgentService->callNvidiaNim([
            ['role' => 'system', 'content' => $systemPrompt],
            ['role' => 'user', 'content' => $userPrompt],
        ], 0.4, 1200, 12);

        if ($apiResult && isset($apiResult['cover_letter'])) {
            return $apiResult;
        }

        // Clean Fallback 3-paragraph Cover Letter Generator
        $p1 = "Dear Hiring Manager at {$companyName},\n\nI am writing to express my strong interest in the {$jobTitle} position. As a developer skilled in {$skills}, I bring hands-on experience building real-world applications and scalable systems that deliver measurable results.";
        $p2 = "Throughout my work, I have {$experience}. My practical background aligns directly with modern development standards. I thrive in collaborative engineering teams where software reliability, code quality, and performance are top priorities.";
        $p3 = "Thank you for reviewing my application. I welcome the opportunity to discuss how my technical background and project experience can contribute to {$companyName}'s engineering goals. I look forward to speaking with you soon.";

        $letter = "{$p1}\n\n{$p2}\n\n{$p3}";

        return [
            'cover_letter' => $letter,
            'key_highlights' => [
                "Proven expertise in {$skills}",
                "Hands-on experience building production software systems",
                "Strong alignment with modern architecture best practices",
            ],
        ];
    }
}
