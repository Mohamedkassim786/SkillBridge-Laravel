<?php

namespace App\Domain\Ai\Resume;

use App\Domain\Ai\Common\LLMProviderFactory;
use App\Domain\Ai\Common\RagKnowledgeService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ResumeSuggestionService
{
    protected RagKnowledgeService $ragKnowledgeService;
    protected LLMProviderFactory $tokenFactory;
    protected ResumeContentAnalyzer $contentAnalyzer;
    protected ResumeAtsAnalyzer $atsAnalyzer;
    protected ResumeExperienceParser $experienceParser;

    public function __construct(
        RagKnowledgeService $ragKnowledgeService,
        LLMProviderFactory $tokenFactory,
        ?ResumeContentAnalyzer $contentAnalyzer = null,
        ?ResumeAtsAnalyzer $atsAnalyzer = null,
        ?ResumeExperienceParser $experienceParser = null
    ) {
        $this->ragKnowledgeService = $ragKnowledgeService;
        $this->tokenFactory = $tokenFactory;
        $this->contentAnalyzer = $contentAnalyzer ?? new ResumeContentAnalyzer();
        $this->atsAnalyzer = $atsAnalyzer ?? new ResumeAtsAnalyzer();
        $this->experienceParser = $experienceParser ?? new ResumeExperienceParser($this->contentAnalyzer);
    }

    /**
     * Perform field-by-field AI analysis on candidate input.
     * Returns an array of field suggestions keyed by field name.
     */
    public function analyzeAllFields(array $userInput): array
    {
        @set_time_limit(60);
        @ini_set('max_execution_time', '60');

        // 1. Run local deterministic content analysis first
        $localSuggestions = $this->runLocalDeterministicAnalysis($userInput);

        $queryText = ($userInput['headlineTitle'] ?? '') . ' ' . ($userInput['skillsInput'] ?? '') . ' ' . ($userInput['experienceSummary'] ?? '');
        $ragContext = $this->ragKnowledgeService->retrieveContext($queryText);

        $systemPrompt = <<<'PROMPT'
You are an expert Certified Professional Resume Writer (CPRW) and AI Resume Editor.

Analyze candidate resume inputs FIELD BY FIELD.

STRICT EDITING RULES (DO NOT VIOLATE):
1. FIELD-SPECIFIC ONLY: Output suggestions keyed strictly by field name (headlineTitle, experienceSummary, location, skillsInput, workExperienceRaw, projectsRaw, educationRaw, certificationsRaw, softSkillsInput).
2. NO HALLUCINATIONS / NO INVENTED FACTS:
   - NEVER invent companies, jobs, dates, degrees, CGPA, or metrics (e.g. "increased sales by 45%", "serving 10,000 users") if not provided by the candidate.
   - NEVER add technologies or skills the candidate did not mention.
   - Improve grammar, spelling, action verbs, and ATS formatting using ONLY candidate-provided facts.
3. HEADLINE: Keep 3–8 words. Fix typos (e.g. "devoloper" -> "Developer", "passionated" -> "passionate").
4. PROFESSIONAL SUMMARY RULE:
   - Technical skills are CONTEXT ONLY. DO NOT copy or dump the entire Technical Skills section into the summary.
   - DO NOT enumerate category names (e.g., "Programming Languages, Frontend Technologies...").
   - Mention at most 2–4 relevant technologies naturally inside sentences (e.g. "building web applications using React, Node.js, and PostgreSQL").
   - Keep summary concise (2–4 sentences).
5. SKILLS: Categorize listed skills cleanly (e.g. Frontend: React.js \n Backend: Node.js). Normalize naming (React Js -> React.js, Node Js -> Node.js, Postgre SQL -> PostgreSQL).
6. WORK EXPERIENCE: Keep internships & jobs under workExperienceRaw. Format with Title — Company | Period and bullet points.
7. PROJECTS: Keep projects under projectsRaw separately.
8. REASON: Provide a short 1-sentence explanation of the fix.

Return ONLY a valid JSON object mapping field names to suggestion objects.
PROMPT;

        $userPrompt = <<<PROMPT
Candidate Resume Inputs:
- fullName: {$userInput['fullName']}
- headlineTitle: {$userInput['headlineTitle']}
- phone: {$userInput['phone']}
- email: {$userInput['email']}
- location: {$userInput['location']}
- experienceSummary: {$userInput['experienceSummary']}
- educationRaw: {$userInput['educationRaw']}
- skillsInput: {$userInput['skillsInput']}
- workExperienceRaw: {$userInput['workExperienceRaw']}
- projectsRaw: {$userInput['projectsRaw']}
- certificationsRaw: {$userInput['certificationsRaw']}
- softSkillsInput: {$userInput['softSkillsInput']}
- targetJobDescription: {$userInput['targetJobDescription']}

RAG Domain Context: {$ragContext['tech_title']}

Return JSON object containing field-by-field suggestions.
PROMPT;

        $fallback = $this->buildFallbackFieldSuggestions($userInput, $ragContext);

        $apiResult = $this->callNimApi([
            ['role' => 'system', 'content' => $systemPrompt],
            ['role' => 'user', 'content' => $userPrompt],
        ]);

        if (is_array($apiResult) && count($apiResult) > 0) {
            $sanitizedApi = $this->sanitizeFieldSuggestions($apiResult);
            foreach ($sanitizedApi as $k => $v) {
                if (is_array($v) && !empty(trim((string) ($v['suggested'] ?? '')))) {
                    $fallback[$k] = $v;
                }
            }
            $merged = array_merge($localSuggestions, $fallback);
            return $this->limitSuggestions($merged);
        }

        $merged = array_merge($localSuggestions, $fallback);
        return $this->limitSuggestions($merged);
    }

    /**
     * Run fast local deterministic rules for immediate validation.
     */
    protected function runLocalDeterministicAnalysis(array $userInput): array
    {
        $suggestions = [];

        // Email validation
        $email = trim($userInput['email'] ?? '');
        if (!empty($email) && !$this->contentAnalyzer->isValidEmail($email)) {
            $suggestions['email'] = [
                'field' => 'email',
                'type' => 'validation',
                'severity' => 'critical',
                'title' => 'Invalid Email Address',
                'reason' => 'Please enter a valid email format (e.g. candidate@example.com).',
                'original' => $email,
                'suggested' => strtolower($email),
                'can_apply' => false,
            ];
        }

        // Phone validation
        $phone = trim($userInput['phone'] ?? '');
        if (!empty($phone) && !$this->contentAnalyzer->isValidPhone($phone)) {
            $suggestions['phone'] = [
                'field' => 'phone',
                'type' => 'validation',
                'severity' => 'warning',
                'title' => 'Check Phone Format',
                'reason' => 'Ensure your phone number includes country code and valid digits.',
                'original' => $phone,
                'suggested' => $phone,
                'can_apply' => false,
            ];
        }

        // Location formatting
        $loc = trim($userInput['location'] ?? '');
        if (!empty($loc)) {
            $normalizedLoc = $this->contentAnalyzer->normalizeLocation($loc);
            if ($normalizedLoc !== $loc) {
                $suggestions['location'] = [
                    'field' => 'location',
                    'type' => 'formatting',
                    'severity' => 'info',
                    'title' => 'Standardize Location Format',
                    'reason' => 'Formatted location into standard City, State title case.',
                    'original' => $loc,
                    'suggested' => $normalizedLoc,
                    'can_apply' => true,
                ];
            }
        }

        // Skill normalization
        $skills = trim($userInput['skillsInput'] ?? '');
        if (!empty($skills)) {
            $normalizedSkills = $this->contentAnalyzer->normalizeSkills($skills);
            if ($normalizedSkills !== $skills) {
                $suggestions['skillsInput'] = [
                    'field' => 'skillsInput',
                    'type' => 'skill_normalization',
                    'severity' => 'warning',
                    'title' => 'Normalize Technical Skill Names',
                    'reason' => 'Standardized technical technology names into ATS canonical format (e.g., React.js, Node.js, PostgreSQL).',
                    'original' => $skills,
                    'suggested' => $normalizedSkills,
                    'can_apply' => true,
                ];
            }
        }

        return $suggestions;
    }

    /**
     * Enforce maximum visible suggestions rule (max 10 overall).
     */
    protected function limitSuggestions(array $suggestions): array
    {
        return array_slice($suggestions, 0, 10, true);
    }

    /**
     * Call NVIDIA NIM API endpoint.
     */
    protected function callNimApi(array $messages): ?array
    {
        $apiKey = config('ai.nvidia.api_key');
        $model = config('ai.nvidia.model', 'meta/llama-3.1-8b-instruct');
        $baseUrl = config('ai.nvidia.base_url', 'https://integrate.api.nvidia.com/v1');

        if (empty($apiKey)) return null;

        try {
            $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => 'Bearer ' . trim($apiKey),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->timeout(12)->post("{$baseUrl}/chat/completions", [
                'model' => $model,
                'messages' => $messages,
                'temperature' => 0.1,
                'max_tokens' => 2048,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $content = $data['choices'][0]['message']['content'] ?? null;
                if ($content) {
                    return $this->parseJson($content);
                }
            }
        } catch (\Throwable $e) {
        }

        return null;
    }

    protected function parseJson(string $content): ?array
    {
        $content = trim($content);
        if (str_contains($content, '```json')) {
            $content = Str::between($content, '```json', '```');
        } elseif (str_contains($content, '```')) {
            $content = Str::between($content, '```', '```');
        }

        $decoded = json_decode(trim($content), true);
        return (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : null;
    }

    protected function flattenToString($value, string $glue = ", "): string
    {
        if (is_null($value)) return '';
        if (is_bool($value)) return $value ? 'true' : 'false';
        if (is_scalar($value)) return trim((string) $value);

        if (is_array($value)) {
            $flat = [];
            array_walk_recursive($value, function ($item) use (&$flat) {
                if (is_scalar($item) && trim((string) $item) !== '') {
                    $flat[] = trim((string) $item);
                }
            });
            return implode($glue, array_unique($flat));
        }

        return '';
    }

    protected function sanitizeFieldSuggestions(array $suggestions): array
    {
        $sanitized = [];
        foreach ($suggestions as $key => $item) {
            if (!is_array($item)) continue;

            if (isset($item['suggested'])) {
                if (is_array($item['suggested'])) {
                    $lines = [];
                    foreach ($item['suggested'] as $k => $v) {
                        $vStr = $this->flattenToString($v, ', ');
                        if (is_string($k) && !is_numeric($k)) {
                            $lines[] = "{$k}: {$vStr}";
                        } else {
                            $lines[] = $vStr;
                        }
                    }
                    $suggestedText = implode("\n", array_filter($lines));
                } else {
                    $suggestedText = (string) $item['suggested'];
                }

                $cleanLines = [];
                foreach (explode("\n", $suggestedText) as $line) {
                    $lineTrim = trim($line);
                    if (empty($lineTrim)) continue;
                    if (preg_match('/:\s*(none|n\/a|null|\-)\s*$/i', $lineTrim)) continue;
                    $cleanLines[] = $lineTrim;
                }
                $item['suggested'] = implode("\n", $cleanLines);
            } else {
                $item['suggested'] = '';
            }

            $item['original'] = isset($item['original']) ? $this->flattenToString($item['original'], "\n") : '';

            $reasonText = isset($item['reason']) ? $this->flattenToString($item['reason'], ' ') : '';
            if (empty($reasonText) || strtolower(trim($reasonText)) === 'string' || strtolower(trim($reasonText)) === 'reason') {
                $reasonText = match ($key) {
                    'headlineTitle' => 'Fixed capitalization, spelling typos, and title formatting in professional headline.',
                    'experienceSummary' => 'Transformed summary into a concise, professional 3-sentence summary.',
                    'educationRaw' => 'Formatted education into a clean ATS line preserving college and CGPA.',
                    'skillsInput' => 'Categorized technical skills into distinct ATS skill groups.',
                    'workExperienceRaw' => 'Structured work experience and internships with company names and bullet points.',
                    'projectsRaw' => 'Structured projects into separate titles, tech stacks, and action-verb bullet points.',
                    'softSkillsInput' => 'Formatted soft skills in title case with corporate terminology.',
                    default => 'Enhanced wording and formatting for professional ATS compliance.',
                };
            }
            $item['reason'] = $reasonText;

            $titleText = isset($item['title']) ? $this->flattenToString($item['title'], ' ') : 'Suggestion';
            if (empty($titleText) || strtolower(trim($titleText)) === 'string') {
                $titleText = match ($key) {
                    'headlineTitle' => 'Headline ATS Enhancement',
                    'experienceSummary' => 'Summary Enhancement',
                    'educationRaw' => 'Education Formatting',
                    'skillsInput' => 'Skills Categorization',
                    'workExperienceRaw' => 'Work Experience Enhancement',
                    'projectsRaw' => 'Projects Enhancement',
                    'softSkillsInput' => 'Soft Skills Enhancement',
                    default => 'Field Enhancement',
                };
            }
            $item['title'] = $titleText;
            $targetKey = match ($key) {
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
                default => $key,
            };

            $item['field'] = $targetKey;
            $item['type'] = (string) ($item['type'] ?? 'improvement');
            $item['severity'] = (string) ($item['severity'] ?? 'warning');
            $item['can_apply'] = isset($item['can_apply']) ? (bool) $item['can_apply'] : (!empty($item['suggested']));

            $sanitized[$targetKey] = $item;
        }

        return $sanitized;
    }

    public function buildFallbackFieldSuggestions(array $userInput, array $ragContext): array
    {
        $suggestions = [];

        // 1. Full Name
        $name = trim($userInput['fullName'] ?? '');
        if (!empty($name)) {
            $properName = ucwords(strtolower($name));
            $suggestions['fullName'] = [
                'field' => 'fullName',
                'type' => 'capitalization',
                'severity' => 'info',
                'title' => 'Name Capitalization',
                'reason' => 'Standardize capitalization for candidate name.',
                'original' => $name,
                'suggested' => $properName,
                'can_apply' => true,
            ];
        }

        // 2. Headline
        $headline = trim($userInput['headlineTitle'] ?? '');
        $normalizedHead = !empty($headline) ? $this->contentAnalyzer->normalizeHeadline($headline) : '';
        $suggestions['headlineTitle'] = [
            'field' => 'headlineTitle',
            'type' => 'headline_enhancement',
            'severity' => 'warning',
            'title' => 'Improve Professional Headline',
            'reason' => !empty($headline) ? 'Standardized headline capitalization and ATS technology formatting.' : 'Add a clear 3-8 word professional headline targeting your desired career role.',
            'original' => $headline,
            'suggested' => !empty($headline) ? ($normalizedHead ?: $headline) : 'Full-Stack Software Developer | React.js | Node.js | PostgreSQL',
            'can_apply' => true,
        ];

        // 3. Summary
        $summary = trim($userInput['experienceSummary'] ?? '');
        $topSkills = $this->extractTopRelevantSkills($userInput['skillsInput'] ?? '', 3);
        $targetDomain = !empty($userInput['headlineTitle']) ? ucwords(strtolower($this->contentAnalyzer->fixTypos($userInput['headlineTitle']))) : 'Full Stack Developer';
        
        $suggestedSummary = !empty($summary)
            ? "Detail-oriented {$targetDomain} with hands-on experience building applications using {$topSkills}. Skilled in developing practical software solutions and interested in building scalable, user-friendly applications."
            : "Motivated {$targetDomain} with hands-on experience in software development and web applications. Skilled in technical problem solving, clean code architecture, and database design. Seeking an opportunity to contribute technical skills to high-impact projects.";

        $suggestions['experienceSummary'] = [
            'field' => 'experienceSummary',
            'type' => 'summary_enhancement',
            'severity' => 'warning',
            'title' => 'Strengthen Professional Summary',
            'reason' => !empty($summary) ? 'Transformed summary into a concise, professional 3-sentence summary incorporating key relevant technologies.' : 'Create a concise 3-sentence professional summary highlighting your core skills and career focus.',
            'original' => $summary,
            'suggested' => $suggestedSummary,
            'can_apply' => true,
        ];

        // 4. Skills
        $skills = trim($userInput['skillsInput'] ?? '');
        $normalizedSkills = !empty($skills) ? $this->contentAnalyzer->normalizeSkills($skills) : '';
        $suggestions['skillsInput'] = [
            'field' => 'skillsInput',
            'type' => 'skill_categorization',
            'severity' => 'warning',
            'title' => 'Organize Technical Skills',
            'reason' => !empty($skills) ? 'Grouped skills into ATS-friendly categories and normalized technology names.' : 'Add your technical skills grouped into categories (e.g. Programming Languages, Frontend, Backend, Databases).',
            'original' => $skills,
            'suggested' => !empty($skills) ? ($normalizedSkills ?: $skills) : "Programming Languages: JavaScript, TypeScript, Python\nFrontend: React.js, HTML5, CSS3, Tailwind CSS\nBackend: Node.js, Express.js, REST APIs\nDatabases: PostgreSQL, MongoDB\nTools: Git, GitHub, VS Code",
            'can_apply' => true,
        ];

        // 5. Work Experience
        $work = trim($userInput['workExperienceRaw'] ?? '');
        if (!empty($work)) {
            $cleanWork = $this->contentAnalyzer->fixTypos($work);
            $suggestions['workExperienceRaw'] = [
                'field' => 'workExperienceRaw',
                'type' => 'experience_enhancement',
                'severity' => 'warning',
                'title' => 'Work Experience Formatting',
                'reason' => 'Fixed typos and formatted work experience into clear action bullet points.',
                'original' => $work,
                'suggested' => $cleanWork ?: $work,
                'can_apply' => true,
            ];
        }

        // 6. Projects
        $projects = trim($userInput['projectsRaw'] ?? '');
        if (!empty($projects)) {
            $parsedProjects = $this->experienceParser->parseProjects($projects);
            $formattedProjects = [];
            foreach ($parsedProjects as $p) {
                $pTitle = $p['title'] ?? 'Project';
                $pTech = !empty($p['tech_stack']) ? " — {$p['tech_stack']}" : '';
                $pBullets = array_map(fn($b) => "- " . rtrim($b, '.'), array_slice($p['bullets'] ?? [], 0, 4));
                
                $formattedProjects[] = "{$pTitle}{$pTech}\n" . implode("\n", $pBullets);
            }
            $suggestedProjectsText = implode("\n\n", $formattedProjects);

            $suggestions['projectsRaw'] = [
                'field' => 'projectsRaw',
                'type' => 'project_enhancement',
                'severity' => 'warning',
                'title' => 'Improve Project Bullets',
                'reason' => 'Structured projects into separate titles, technology stacks, and concise action-verb bullet points.',
                'original' => $projects,
                'suggested' => $suggestedProjectsText ?: $projects,
                'can_apply' => true,
            ];
        }

        // 7. Location
        $loc = trim($userInput['location'] ?? '');
        if (!empty($loc)) {
            $normalizedLoc = $this->contentAnalyzer->normalizeLocation($loc);
            $suggestions['location'] = [
                'field' => 'location',
                'type' => 'formatting',
                'severity' => 'info',
                'title' => 'Standardize Location Format',
                'reason' => 'Formatted location into standard City, State title case.',
                'original' => $loc,
                'suggested' => $normalizedLoc ?: $loc,
                'can_apply' => true,
            ];
        }

        // 7. Soft Skills
        $soft = trim($userInput['softSkillsInput'] ?? '');
        if (!empty($soft)) {
            $cleanSoft = ucwords(strtolower($this->contentAnalyzer->fixTypos($soft)));
            if ($cleanSoft !== $soft) {
                $suggestions['softSkillsInput'] = [
                    'field' => 'softSkillsInput',
                    'type' => 'formatting',
                    'severity' => 'info',
                    'title' => 'Soft Skills Formatting',
                    'reason' => 'Formatted soft skills in title case with corporate terminology.',
                    'original' => $soft,
                    'suggested' => $cleanSoft,
                    'can_apply' => true,
                ];
            }
        }

        return $suggestions;
    }

    /**
     * Extract top 2-4 clean skill names without category headers for natural summary phrasing.
     */
    protected function extractTopRelevantSkills(string $skillsInput, int $maxSkills = 3): string
    {
        if (empty(trim($skillsInput))) {
            return 'modern software tools';
        }

        $lines = explode("\n", $skillsInput);
        $extracted = [];

        foreach ($lines as $line) {
            $lineTrim = trim($line);
            if (empty($lineTrim)) continue;

            if (str_contains($lineTrim, ':')) {
                $parts = explode(':', $lineTrim, 2);
                $skillsStr = trim($parts[1]);
            } else {
                $skillsStr = $lineTrim;
            }

            $items = array_filter(array_map('trim', explode(',', $skillsStr)));
            foreach ($items as $item) {
                if (preg_match('/^(programming|languages|frontend|backend|databases|tools|frameworks|cloud|devops)\b/i', $item)) {
                    continue;
                }
                if (!empty($item) && !in_array($item, $extracted)) {
                    $extracted[] = $item;
                }
            }
        }

        $selected = array_slice($extracted, 0, $maxSkills);
        if (empty($selected)) {
            return 'modern software tools';
        }

        if (count($selected) === 1) {
            return $selected[0];
        }
        if (count($selected) === 2) {
            return $selected[0] . ' and ' . $selected[1];
        }

        $last = array_pop($selected);
        return implode(', ', $selected) . ', and ' . $last;
    }
}
