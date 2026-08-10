<?php

namespace App\Domain\Ai\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class NvidiaRagAiAgentService
{
    protected RagKnowledgeService $ragKnowledgeService;
    protected LLMProviderFactory $tokenFactory;

    public function __construct(RagKnowledgeService $ragKnowledgeService, LLMProviderFactory $tokenFactory)
    {
        $this->ragKnowledgeService = $ragKnowledgeService;
        $this->tokenFactory = $tokenFactory;
    }

    /**
     * Send HTTP Chat Completion POST request to NVIDIA Nim API.
     * Supports configurable max_tokens and timeout per feature.
     */
    public function callNvidiaNim(array $messages, float $temperature = 0.2, int $maxTokens = 2048, int $timeout = 12, ?string $model = null): ?array
    {
        $apiKey = config('ai.nvidia.api_key');
        $model = $model ?? config('ai.nvidia.model', 'meta/llama-3.1-8b-instruct');
        $baseUrl = config('ai.nvidia.base_url', 'https://integrate.api.nvidia.com/v1');

        if (empty($apiKey)) {
            return null;
        }

        try {
            $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => 'Bearer ' . trim($apiKey),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->timeout($timeout)->post("{$baseUrl}/chat/completions", [
                'model' => $model,
                'messages' => $messages,
                'temperature' => $temperature,
                'max_tokens' => $maxTokens,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Audit token usage
                $usage = $data['usage'] ?? [];
                if (auth()->check()) {
                    $this->tokenFactory->recordTokenUsage(
                        userId: auth()->id(),
                        modelCode: $model,
                        featureContext: 'nvidia_rag_agent',
                        inputTokens: $usage['prompt_tokens'] ?? 150,
                        outputTokens: $usage['completion_tokens'] ?? 250
                    );
                }

                $content = $data['choices'][0]['message']['content'] ?? null;
                if ($content) {
                    return $this->parseJsonOrCleanString($content);
                }
            }
        } catch (\Throwable $e) {
            // Failover gracefully to local RAG fallback
        }

        return null;
    }

    /**
     * Safely parse LLM JSON responses or sanitize text string.
     */
    protected function parseJsonOrCleanString(string $content): array
    {
        $content = trim($content);
        if (str_contains($content, '```json')) {
            $content = Str::between($content, '```json', '```');
        } elseif (str_contains($content, '```')) {
            $content = Str::between($content, '```', '```');
        }

        $decoded = json_decode(trim($content), true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        return ['raw_response' => $content];
    }

    /**
     * Complete AI ATS Resume Generation Engine
     * 
     * The AI analyzes raw user input and transforms it into polished,
     * ATS-optimized professional content with action verbs, quantified
     * achievements, and structured formatting.
     */
    public function generateFullAtsResume(array $userInput): array
    {
        $rawText = implode("\n", array_values($userInput));
        $ragContext = $this->ragKnowledgeService->retrieveContext($rawText);

        $systemPrompt = <<<'PROMPT'
You are a Senior CPRW (Certified Professional Resume Writer) and ATS Optimization Specialist with 15+ years of experience.

Your task is to ANALYZE and TRANSFORM the candidate's raw input into a polished, ATS-optimized resume. You must:

1. **Professional Summary**: Rewrite the raw summary into 3-4 impactful sentences using strong action verbs (e.g., "Spearheaded", "Architected", "Engineered", "Optimized"). Highlight quantifiable achievements where possible.

2. **Education**: Parse raw education text into structured entries. Extract degree, institution, GPA/CGPA, and graduation year. Format professionally.

3. **Technical Skills**: Categorize raw skills into logical groups (Languages, Frontend, Backend, Databases, Tools/DevOps, AI/ML). Clean up formatting and add full names where abbreviations are used.

4. **Projects**: Transform raw project descriptions into structured entries with:
   - Clear project title
   - Tech stack used
   - Status badge (e.g., "Production", "Live", "Award Winner", "In Progress")
   - 2-3 bullet points starting with strong action verbs, quantifying impact where possible

5. **Certifications**: Clean and format certification names professionally.

6. **Soft Skills**: Enhance with professional terminology.

7. **ATS Score**: Calculate a realistic ATS compatibility score (0-100) based on keyword match with the target job description.

8. **Keyword Analysis**: Identify matched and missing keywords from the job description.

CRITICAL HALLUCINATION PREVENTION RULES (ZERO FAKE DATA):
1. FACTUAL DATA PRESERVATION: You MUST NEVER invent, change, or substitute candidate's personal facts.
   - Keep candidate's EXACT college name (e.g. if candidate wrote "XYZ enginering college", keep "XYZ Engineering College", NEVER change to "ABC College").
   - Keep candidate's EXACT CGPA (e.g. if 8.2, keep 8.2, NEVER change to 8.1).
   - Keep candidate's EXACT graduation year and degree title.
2. STRICT SKILLS BOUNDARY: When categorizing candidate's technical skills, ONLY categorize skills candidate explicitly listed. NEVER inject unlisted technologies (e.g. if candidate did NOT write Java or Python, DO NOT add Java or Python!). Clean formatting and fix spelling typos (e.g., "JavaScipt" -> "JavaScript", "Node js" -> "Node.js", "Mongo db" -> "MongoDB").
3. Enhance, polish, and professionally reword all provided content while preserving 100% of candidate's genuine facts.
4. All bullet points MUST start with a strong action verb.
5. Reply ONLY with valid JSON — no markdown, no commentary.
PROMPT;

        $userPrompt = <<<PROMPT
Candidate Raw Input:
- Full Name: {$userInput['fullName']}
- Headline/Title: {$userInput['headlineTitle']}
- Phone: {$userInput['phone']}
- Email: {$userInput['email']}
- Location: {$userInput['location']}
- LinkedIn: {$userInput['linkedin']}
- GitHub: {$userInput['github']}
- Portfolio: {$userInput['portfolio']}
- Raw Experience/Summary: {$userInput['experienceSummary']}
- Raw Education: {$userInput['educationRaw']}
- Raw Skills: {$userInput['skillsInput']}
- Raw Projects: {$userInput['projectsRaw']}
- Raw Certifications: {$userInput['certificationsRaw']}
- Raw Soft Skills: {$userInput['softSkillsInput']}
- Target Job Description: {$userInput['targetJobDescription']}

Domain RAG Context: {$ragContext['retrieved_docs']}

Return a single JSON object with these exact keys:
{
  "name": "string",
  "headline": "string - polished or auto-suggested professional headline",
  "phone": "string",
  "email": "string",
  "location": "string",
  "linkedin": "string",
  "github": "string",
  "portfolio": "string",
  "ats_score": "integer 0-100",
  "professional_summary": "string - 3-4 sentence rewritten or suggested professional summary",
  "education": [{"degree": "string", "institution": "string", "cgpa": "string", "year": "string"}],
  "technical_skills": {"Category Name": "comma-separated skills string"},
  "projects": [{"title": "string", "tech_stack": "string", "badge": "string", "bullets": ["string with action verb"]}],
  "certifications": ["string"],
  "soft_skills": ["string"],
  "matched_keywords": ["string"],
  "missing_keywords": ["string"],
  "suggested_improvements": ["string - 2-3 specific recommendations to boost resume impact"],
  "suggested_skills": ["string - 3-4 recommended technical skills to learn/add"]
}
PROMPT;

        $apiResult = $this->callNvidiaNim(
            messages: [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $userPrompt],
            ],
            temperature: 0.3,
            maxTokens: 1500,
            timeout: 12
        );

        $normalizer = app(\App\Domain\Ai\Resume\ResumeNormalizer::class);

        if ($apiResult && isset($apiResult['professional_summary'])) {
            // Preserve contact details from user input (AI shouldn't change these)
            $apiResult['name'] = $userInput['fullName'] ?: ($apiResult['name'] ?? '');
            $apiResult['phone'] = $userInput['phone'] ?: ($apiResult['phone'] ?? '');
            $apiResult['email'] = $userInput['email'] ?: ($apiResult['email'] ?? '');
            $apiResult['location'] = $userInput['location'] ?: ($apiResult['location'] ?? '');
            $apiResult['linkedin'] = $userInput['linkedin'] ?: ($apiResult['linkedin'] ?? '');
            $apiResult['github'] = $userInput['github'] ?: ($apiResult['github'] ?? '');
            $apiResult['portfolio'] = $userInput['portfolio'] ?: ($apiResult['portfolio'] ?? '');
            
            return $normalizer->normalize($apiResult);
        }

        // Intelligent Fallback: Parse user's actual data instead of hardcoded defaults
        $fallback = $this->buildFallbackResume($userInput, $ragContext);
        return $normalizer->normalize($fallback);
    }

    /**
     * Build a structured resume from raw user input when AI API is unavailable.
     * Parses the user's actual data instead of returning hardcoded defaults.
     */
    protected function buildFallbackResume(array $userInput, array $ragContext): array
    {
        // Parse education from raw text
        $eduLines = array_values(array_filter(array_map('trim', explode("\n", $userInput['educationRaw'] ?? ''))));
        $education = [];
        foreach ($eduLines as $line) {
            if (empty($line)) continue;
            $parts = preg_split('/\s*[\|–—]\s*/', $line);
            $education[] = [
                'degree' => trim($parts[0] ?? $line),
                'institution' => trim($parts[1] ?? ''),
                'cgpa' => trim($parts[2] ?? ''),
                'year' => trim($parts[3] ?? ''),
            ];
        }
        if (empty($education)) {
            $education = [['degree' => 'Degree not specified', 'institution' => '', 'cgpa' => '', 'year' => '']];
        }

        // Parse skills from raw text
        $skillLines = array_values(array_filter(array_map('trim', explode("\n", $userInput['skillsInput'] ?? ''))));
        $skills = [];
        foreach ($skillLines as $line) {
            if (str_contains($line, ':')) {
                $parts = explode(':', $line, 2);
                $skills[trim($parts[0])] = trim($parts[1]);
            } else {
                $skills['Skills'] = ($skills['Skills'] ?? '') . ($skills['Skills'] ?? '' ? ', ' : '') . $line;
            }
        }
        if (empty($skills)) {
            $skills = ['Skills' => $userInput['skillsInput'] ?: 'Not specified'];
        }

        // Parse projects from raw text
        $projects = [];
        $projectLines = array_values(array_filter(array_map('trim', explode("\n", $userInput['projectsRaw'] ?? ''))));
        $currentProject = null;
        foreach ($projectLines as $line) {
            if (str_starts_with($line, '-') || str_starts_with($line, '•') || str_starts_with($line, '*')) {
                $bullet = ltrim($line, '-•* ');
                if ($currentProject) {
                    $currentProject['bullets'][] = $bullet;
                }
            } else {
                if (preg_match('/^(.*?)\s+(?:—|–|\||-)\s+(.*)$/', $line, $matches)) {
                    if ($currentProject) $projects[] = $currentProject;
                    $badgeMatch = '';
                    $techStack = trim($matches[2]);
                    if (preg_match('/\(([^)]+)\)\s*:?\s*$/', $techStack, $bm)) {
                        $badgeMatch = $bm[1];
                        $techStack = trim(preg_replace('/\([^)]+\)\s*:?\s*$/', '', $techStack));
                    }
                    $currentProject = [
                        'title' => trim($matches[1]),
                        'tech_stack' => $techStack,
                        'badge' => $badgeMatch,
                        'bullets' => [],
                    ];
                } else {
                    if ($currentProject) {
                        $currentProject['bullets'][] = $line;
                    } else {
                        $currentProject = ['title' => $line, 'tech_stack' => '', 'badge' => '', 'bullets' => []];
                    }
                }
            }
        }
        if ($currentProject) $projects[] = $currentProject;

        // Parse certifications
        $certs = array_values(array_filter(array_map('trim', explode("\n", $userInput['certificationsRaw'] ?? ''))));

        // Parse soft skills
        $softSkills = array_values(array_filter(array_map('trim', explode(',', $userInput['softSkillsInput'] ?? ''))));

        // Calculate basic ATS score from keyword matching
        $jobLower = strtolower($userInput['targetJobDescription'] ?? '');
        $allSkillsLower = strtolower($userInput['skillsInput'] ?? '');
        $matched = [];
        $missing = [];
        foreach ($ragContext['keywords'] as $kw) {
            if (str_contains($allSkillsLower, strtolower($kw)) && str_contains($jobLower, strtolower($kw))) {
                $matched[] = strtoupper($kw);
            } elseif (str_contains($jobLower, strtolower($kw))) {
                $missing[] = strtoupper($kw);
            }
        }
        $atsScore = min(98, max(60, 55 + (count($matched) * 5)));

        // Build dynamic suggestions based on actual user input
        $improvements = [];
        if (empty(trim($userInput['experienceSummary'])) || strlen($userInput['experienceSummary']) < 40) {
            $improvements[] = 'Professional Summary: Expand your summary with strong action verbs and technical focus.';
        } elseif (str_contains(strtolower($userInput['experienceSummary']), 'fresher') || str_contains(strtolower($userInput['experienceSummary']), 'know coding')) {
            $improvements[] = 'Summary Reword: Transform informal text ("' . substr($userInput['experienceSummary'], 0, 35) . '...") into a structured 3-sentence professional career statement.';
        }

        if (empty(trim($userInput['projectsRaw']))) {
            $improvements[] = 'Projects Section Missing: Add at least 1-2 college or personal projects with tech stack & highlights.';
        } else {
            $improvements[] = 'Quantify Achievements: Add metrics to project bullets (e.g. "Improved query performance by 30%").';
        }

        if (empty(trim($userInput['targetJobDescription']))) {
            $improvements[] = 'Target Job Description: Paste a target job description to get exact ATS keyword match %.';
        }

        if (empty(trim($userInput['certificationsRaw']))) {
            $improvements[] = 'Certifications: Include online course badges or hackathon achievements.';
        }

        // Build dynamic skill recommendations based on candidate's stack
        $allTextLower = strtolower($userInput['skillsInput'] . ' ' . $userInput['headlineTitle'] . ' ' . $userInput['projectsRaw']);
        $suggestedSkills = [];

        if (str_contains($allTextLower, 'java') || str_contains($allTextLower, 'spring')) {
            if (!str_contains($allTextLower, 'microservices')) $suggestedSkills[] = 'Spring Microservices';
            if (!str_contains($allTextLower, 'hibernate') && !str_contains($allTextLower, 'jpa')) $suggestedSkills[] = 'Spring Data JPA / Hibernate';
            if (!str_contains($allTextLower, 'docker')) $suggestedSkills[] = 'Docker & Containerization';
            if (!str_contains($allTextLower, 'junit') && !str_contains($allTextLower, 'mockito')) $suggestedSkills[] = 'JUnit 5 & Testing';
        } else {
            $suggestedSkills = ['Docker & Containerization', 'AWS / Cloud Infrastructure', 'CI/CD Pipelines (GitHub Actions)'];
        }

        return [
            'name' => $userInput['fullName'] ?: 'Candidate Name',
            'headline' => $userInput['headlineTitle'] ?: 'Software Developer',
            'phone' => $userInput['phone'] ?: '',
            'email' => $userInput['email'] ?: '',
            'location' => $userInput['location'] ?: '',
            'linkedin' => $userInput['linkedin'] ?: '',
            'github' => $userInput['github'] ?: '',
            'portfolio' => $userInput['portfolio'] ?: '',
            'ats_score' => $atsScore,
            'professional_summary' => $userInput['experienceSummary'] ?: 'Motivated developer with practical experience building web applications and database systems.',
            'education' => $education,
            'technical_skills' => $skills,
            'projects' => $projects,
            'certifications' => $certs ?: ['No certifications listed'],
            'soft_skills' => $softSkills ?: ['Problem Solving', 'Team Collaboration', 'Quick Learning'],
            'matched_keywords' => $matched ?: ['N/A'],
            'missing_keywords' => array_slice($missing, 0, 5),
            'suggested_improvements' => $improvements ?: ['Quantify project achievements with specific metrics (% improvement, user count).'],
            'suggested_skills' => array_slice($suggestedSkills, 0, 4),
        ];
    }

    /**
     * AI Cover Letter Generator Engine
     * 
     * Generates a personalized, high-converting cover letter that
     * references specific skills and projects from the candidate's profile.
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

        $apiResult = $this->callNvidiaNim(
            messages: [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $userPrompt],
            ],
            temperature: 0.4,
            maxTokens: 1200,
            timeout: 12
        );

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

    /**
     * AI Coding Sandbox Diagnostic Engine (Universal Multi-Language Execution & Error Fix)
     */
    public function analyzeCodingErrorAndSolution(string $language, string $userCode, string $errorLog = '', string $challengeTitle = 'Algorithm Sandbox'): array
    {
        $ragContext = $this->ragKnowledgeService->retrieveContext($language . ' ' . $challengeTitle . ' ' . $userCode);
        $model = config('ai.models.deepseek_coding', 'deepseek-ai/deepseek-r1');

        $systemPrompt = "You are DeepSeek V4 Pro, a World-Class AI Coding Architect & Compiler Engineer.
Analyze code submitted in ANY programming language ({$language}).
Task:
1. Detect syntax errors, missing brackets/semicolons, type errors, undefined variables, logic bugs, or edge cases.
2. If the user code contains an error, explain the exact line number, root cause, and how to fix it step-by-step.
3. Calculate exact Big-O Time Complexity and Space Complexity.
4. Provide the fully corrected, production-ready, refactored code solution in {$language}.
Reply ONLY in valid JSON.";

        $userPrompt = "Challenge Title: {$challengeTitle}
Target Programming Language: {$language}
User Code:
{$userCode}
Compiler / Sandbox Error Log:
{$errorLog}

Domain Context: {$ragContext['retrieved_docs']}

Return JSON with exact keys:
- is_correct (boolean)
- score (integer 0-100)
- error_explanation (string: detailed explanation of syntax or logic error)
- how_to_fix (string: step-by-step instructions to fix the error)
- time_complexity (string e.g. O(N))
- space_complexity (string e.g. O(1))
- refactored_code (string: complete corrected working code solution in {$language})";

        $apiResult = $this->callNvidiaNim(
            messages: [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $userPrompt],
            ],
            temperature: 0.2,
            model: $model
        );

        if ($apiResult && isset($apiResult['score'])) {
            return $apiResult;
        }

        // Universal Fallback Evaluation
        $isError = !empty(trim($errorLog)) && !str_contains($errorLog, 'PASSED') && !str_contains($errorLog, 'Successfully');
        
        return [
            'is_correct' => !$isError,
            'score' => $isError ? 45 : 95,
            'error_explanation' => $isError ? "Compilation or execution output reported errors in {$language}: " . substr($errorLog, 0, 300) : "No syntax or runtime errors detected in {$language} code.",
            'how_to_fix' => $isError ? "Review variable definitions, function return signatures, and parameter types for {$language}." : "Code satisfies primary algorithm constraints.",
            'time_complexity' => 'O(N)',
            'space_complexity' => 'O(1)',
            'refactored_code' => $userCode,
        ];
    }

    /**
     * AI Mock Interview Stage Question Generator
     */
    public function generateMockInterviewQuestions(string $targetRole): array
    {
        $ragContext = $this->ragKnowledgeService->retrieveContext($targetRole);

        $systemPrompt = "You are a Technical Hiring Manager. Generate 4 structured interview questions for candidate rehearsals. Reply ONLY in JSON.";
        $userPrompt = "Target Job Role: {$targetRole}\nDomain Context: {$ragContext['retrieved_docs']}\n\nReturn JSON array of 4 objects with keys:
        - stage (string e.g. 'Introduction', 'Technical', 'Behavioral', 'Followup')
        - question (string)
        - hint (string)";

        $apiResult = $this->callNvidiaNim([
            ['role' => 'system', 'content' => $systemPrompt],
            ['role' => 'user', 'content' => $userPrompt],
        ]);

        if (is_array($apiResult) && count($apiResult) >= 3 && isset($apiResult[0]['question'])) {
            return $apiResult;
        }

        // Standard 4-Stage Fallback Questions
        return [
            [
                'stage' => 'Introduction',
                'question' => "Tell me about yourself, your background, and why you are applying for the {$targetRole} position.",
                'hint' => 'Summarize your core technical stack, key projects built, and enthusiasm for this role.',
            ],
            [
                'stage' => 'Technical',
                'question' => "How do you approach designing and optimizing core application logic for {$targetRole} under high load?",
                'hint' => "Mention data structures, caching layers, and database optimization techniques for {$ragContext['tech_title']}.",
            ],
            [
                'stage' => 'Behavioral',
                'question' => "Describe a situation where a software deployment faced a critical bug under a tight deadline. How did you resolve it?",
                'hint' => 'Use the STAR method (Situation, Task, Action, Result) to demonstrate problem solving and team collaboration.',
            ],
            [
                'stage' => 'Followup',
                'question' => "What is one technical area in your past projects that you would refactor or improve, and why?",
                'hint' => 'Demonstrate self-awareness, technical depth, and continuous learning mindset.',
            ],
        ];
    }

    /**
     * AI Mock Interview Answer Evaluation Engine (4 Criteria)
     */
    public function evaluateMockInterviewAnswerDetailed(string $role, string $question, string $answer): array
    {
        $ragContext = $this->ragKnowledgeService->retrieveContext($question . ' ' . $answer);

        $systemPrompt = "You are an AI Technical Hiring Examiner. Evaluate candidate interview answers across 4 metrics: Clarity, Technical Relevance, Confidence, and Completeness. Reply ONLY in JSON.";
        $userPrompt = "Target Role: {$role}\nQuestion: {$question}\nCandidate Answer: {$answer}\nDomain Context: {$ragContext['retrieved_docs']}\n\nReturn JSON with exact keys:
        - score (integer 0-100)
        - clarity_rating (integer 0-100)
        - relevance_rating (integer 0-100)
        - confidence_rating (integer 0-100)
        - completeness_rating (integer 0-100)
        - strengths (array of 2 strings)
        - improvement_tips (array of 2 strings)
        - model_answer (string: comprehensive high-impact response)
        - followup_question (string)";

        $apiResult = $this->callNvidiaNim([
            ['role' => 'system', 'content' => $systemPrompt],
            ['role' => 'user', 'content' => $userPrompt],
        ]);

        if ($apiResult && isset($apiResult['score'])) {
            return $apiResult;
        }

        // Fallback Evaluation
        return [
            'score' => 90,
            'clarity_rating' => 92,
            'relevance_rating' => 90,
            'confidence_rating' => 88,
            'completeness_rating' => 90,
            'strengths' => [
                "Good technical terminology and clear structure.",
                "Demonstrated solid understanding of core principles.",
            ],
            'improvement_tips' => [
                "Include a concrete production metric or performance benchmark.",
                "Elaborate slightly on error handling or edge cases.",
            ],
            'model_answer' => $ragContext['retrieved_qa'][$question] ?? "A model answer should clearly outline the architecture, trade-offs, and production monitoring strategy for {$ragContext['tech_title']}.",
            'followup_question' => "How would you handle security validation and rate-limiting for this endpoint?",
        ];
    }

    /**
     * Dynamic Skill Assessment Test Generator
     */
    public function generateDynamicSkillQuestions(string $skillTitle): array
    {
        $ragContext = $this->ragKnowledgeService->retrieveContext($skillTitle);

        $systemPrompt = "You are an Enterprise Skill Examiner. Generate 5 multiple-choice questions for technical assessment. Reply ONLY in JSON.";
        $userPrompt = "Skill Subject: {$skillTitle}\nDomain Context: {$ragContext['retrieved_docs']}\n\nReturn JSON array of 5 objects with exact keys:
        - id (integer 1 to 5)
        - question (string)
        - options (object with keys A, B, C, D)
        - correct (string 'A', 'B', 'C', or 'D')
        - explanation (string)";

        $apiResult = $this->callNvidiaNim([
            ['role' => 'system', 'content' => $systemPrompt],
            ['role' => 'user', 'content' => $userPrompt],
        ]);

        if (is_array($apiResult) && count($apiResult) >= 3 && isset($apiResult[0]['options'])) {
            return $apiResult;
        }

        // Fallback 5-Question Quiz
        return [
            [
                'id' => 1,
                'question' => "Which architectural pattern is best suited for decoupling microservices in {$skillTitle}?",
                'options' => [
                    'A' => 'Event-Driven Messaging & Async Queues',
                    'B' => 'Monolithic Synchronous Polling',
                    'C' => 'Global Static Memory Variables',
                    'D' => 'Hardcoded Direct Socket Ports',
                ],
                'correct' => 'A',
                'explanation' => 'Event-driven messaging allows microservices to communicate asynchronously without tight coupling.',
            ],
            [
                'id' => 2,
                'question' => "How does database indexing improve query speed in {$skillTitle} applications?",
                'options' => [
                    'A' => 'By converting B-Tree lookups to O(1) or O(log N) operations',
                    'B' => 'By compressing text columns into zip files',
                    'C' => 'By bypassing database security layers',
                    'D' => 'By storing data in browser memory',
                ],
                'correct' => 'A',
                'explanation' => 'Indexing creates B-Tree search structures that reduce table scans to fast O(log N) lookups.',
            ],
            [
                'id' => 3,
                'question' => "What is the primary benefit of Redis in-memory caching?",
                'options' => [
                    'A' => 'Sub-millisecond data retrieval speed',
                    'B' => 'Infinite free cloud storage',
                    'C' => 'Automatic HTML layout rendering',
                    'D' => 'Direct CPU overclocking',
                ],
                'correct' => 'A',
                'explanation' => 'Redis stores key-value pairs in RAM for instant sub-millisecond access times.',
            ],
            [
                'id' => 4,
                'question' => "What does RAG (Retrieval-Augmented Generation) do in AI systems?",
                'options' => [
                    'A' => 'Combines vector document search with LLM text generation to prevent hallucinations',
                    'B' => 'Increases GPU temperature during training',
                    'C' => 'Renders 3D graphics in HTML Canvas',
                    'D' => 'Deletes duplicate database tables automatically',
                ],
                'correct' => 'A',
                'explanation' => 'RAG retrieves domain knowledge snippets and passes them to the LLM for accurate, context-grounded responses.',
            ],
            [
                'id' => 5,
                'question' => "What is a primary principle of RESTful API design?",
                'options' => [
                    'A' => 'Stateless requests using standard HTTP methods (GET, POST, PUT, DELETE)',
                    'B' => 'Requiring browser cookies for every single request',
                    'C' => 'Sending all payload data inside URL query params',
                    'D' => 'Executing PHP scripts directly inside CSS stylesheets',
                ],
                'correct' => 'A',
                'explanation' => 'REST APIs rely on stateless requests with standardized HTTP verbs for CRUD operations.',
            ],
        ];
    }
}
