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

    public function __construct(RagKnowledgeService $ragKnowledgeService, LLMProviderFactory $tokenFactory)
    {
        $this->ragKnowledgeService = $ragKnowledgeService;
        $this->tokenFactory = $tokenFactory;
    }

    /**
     * Perform field-by-field AI analysis on candidate input.
     * Returns an array of field suggestions keyed by field name.
     */
    public function analyzeAllFields(array $userInput): array
    {
        @set_time_limit(60);
        @ini_set('max_execution_time', '60');

        $queryText = ($userInput['headlineTitle'] ?? '') . ' ' . ($userInput['skillsInput'] ?? '') . ' ' . ($userInput['experienceSummary'] ?? '');
        $ragContext = $this->ragKnowledgeService->retrieveContext($queryText);

        $systemPrompt = <<<'PROMPT'
You are a Senior AI Resume Product Designer and CPRW Certified Professional Resume Writer.

Analyze candidate resume form inputs FIELD BY FIELD for ANY career domain (Software, Embedded/IoT, Data Analyst, DevOps, UI/UX, Cyber Security, Robotics, etc.).

CRITICAL INSTRUCTIONS:
1. HEADLINE ENHANCEMENT: ALWAYS analyze headlineTitle for typos, spelling errors, capitalization, and ATS formatting.
2. STRICT ROLE ALIGNMENT: Read candidate's target role and summary text. Tailor suggestions specifically for THAT domain.
3. FACTUAL DATA PRESERVATION: Keep candidate's EXACT college name, CGPA, and graduation year. NEVER change college names or CGPA numbers!
4. FIX ALL TYPOS & SPELLING: Fix all spelling mistakes across all fields.
5. PROJECTS MULTILINE FORMATTING: Format EACH project on its own separate block with Title — Tech Stack on Line 1, followed by action-verb bullet points on Line 2+.
6. NO EMPTY "NONE" CATEGORIES IN SKILLS: ONLY include categories that contain real candidate skills on separate lines.
7. REASON FIELD: Write a clear 1-sentence explanation of what was improved. NEVER return the word "string" in reason!

Reply ONLY in valid JSON with field names as keys.
PROMPT;

        $userPrompt = <<<PROMPT
Candidate Resume Input:
- fullName: {$userInput['fullName']}
- headlineTitle: {$userInput['headlineTitle']}
- phone: {$userInput['phone']}
- email: {$userInput['email']}
- location: {$userInput['location']}
- experienceSummary: {$userInput['experienceSummary']}
- educationRaw: {$userInput['educationRaw']}
- skillsInput: {$userInput['skillsInput']}
- projectsRaw: {$userInput['projectsRaw']}
- certificationsRaw: {$userInput['certificationsRaw']}
- softSkillsInput: {$userInput['softSkillsInput']}
- targetJobDescription: {$userInput['targetJobDescription']}

RAG Domain Title: {$ragContext['tech_title']}

Return JSON object. Ensure projects are formatted on MULTIPLE SEPARATE LINES with title and - bullet points. Never return the word "string" in reason.
PROMPT;

        $apiResult = $this->callNimApi([
            ['role' => 'system', 'content' => $systemPrompt],
            ['role' => 'user', 'content' => $userPrompt],
        ]);

        if (is_array($apiResult) && count($apiResult) > 0) {
            return $this->sanitizeFieldSuggestions($apiResult);
        }

        return $this->sanitizeFieldSuggestions($this->buildFallbackFieldSuggestions($userInput, $ragContext));
    }

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

                if ($key === 'skillsInput') {
                    if (str_contains($suggestedText, ';')) {
                        $suggestedText = str_replace(';', "\n", $suggestedText);
                    }
                    $suggestedText = preg_replace_callback('/([A-Za-z0-9\s\/]+:)/', function ($m) {
                        return str_replace("\n", " ", $m[1]);
                    }, $suggestedText);
                    $suggestedText = preg_replace('/(?<=[a-zA-Z0-9,\.\)])\s+(?=[A-Z][A-Za-z0-9\s\/]+:)/', "\n", $suggestedText);
                }

                if ($key === 'projectsRaw') {
                    $suggestedText = $this->formatProjectsText($suggestedText);
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
                    'headlineTitle' => 'Fixed capitalization and spelling typos in professional headline.',
                    'experienceSummary' => 'Transformed informal summary into a strong 3-sentence professional summary.',
                    'educationRaw' => 'Formatted education into a single clean ATS line preserving college and CGPA.',
                    'skillsInput' => 'Categorized technical skills into distinct ATS skill groups.',
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
                    'projectsRaw' => 'Projects Enhancement',
                    'softSkillsInput' => 'Soft Skills Enhancement',
                    default => 'Field Enhancement',
                };
            }
            $item['title'] = $titleText;
            $item['field'] = (string) ($item['field'] ?? $key);

            $sanitized[$key] = $item;
        }

        return $sanitized;
    }

    protected function fixCommonTypos(string $text): string
    {
        $map = [
            '/\benginer\b/i' => 'Engineer',
            '/\benginering\b/i' => 'Engineering',
            '/\bengineerng\b/i' => 'Engineering',
            '/\bdesiner\b/i' => 'Designer',
            '/\bdesgin\b/i' => 'Design',
            '/\bdevlopor\b/i' => 'Developer',
            '/\bdevloper\b/i' => 'Developer',
            '/\bvison\b/i' => 'Vision',
            '/\bexperiance\b/i' => 'Experience',
            '/\bmovment\b/i' => 'Movement',
            '/\bavoidence\b/i' => 'Avoidance',
            '/\benviroment\b/i' => 'Environment',
            '/\boppurtunity\b/i' => 'Opportunity',
            '/\badvance\b/i' => 'Advanced',
            '/\bintrested\b/i' => 'Interested',
            '/\bcomunication\b/i' => 'Communication',
            '/\bmanagment\b/i' => 'Management',
            '/\banalysed\b/i' => 'Analyzed',
            '/\bfinded\b/i' => 'Identified',
            '/\bquering\b/i' => 'Querying',
            '/\battandance\b/i' => 'Attendance',
            '/\btamilnadu\b/i' => 'Tamil Nadu',
            '/\bkarnataka\b/i' => 'Karnataka',
            '/\bmaharashtra\b/i' => 'Maharashtra',
            '/\btelangana\b/i' => 'Telangana',
            '/\bkerala\b/i' => 'Kerala',
        ];

        return preg_replace(array_keys($map), array_values($map), $text);
    }

    protected function formatProjectsText(string $rawText): string
    {
        $rawText = $this->fixCommonTypos($rawText);

        $lines = array_values(array_filter(array_map('trim', explode("\n", $rawText))));
        if (empty($lines)) return $rawText;

        $projects = [];
        $current = null;

        foreach ($lines as $line) {
            $cleanLine = trim($line);
            if (empty($cleanLine)) continue;

            $isBullet = preg_match('/^\s*[\-\•\*]\s*/', $cleanLine);
            if ($isBullet) {
                $bulletText = preg_replace('/^\s*[\-\•\*]\s*/', '', $cleanLine);
                if ($current) {
                    $current['bullets'][] = ucfirst($bulletText);
                }
                continue;
            }

            $isHeader = false;
            $title = $cleanLine;
            $techStack = '';

            if (preg_match('/^(.*?)\s*(?:—|–|\|)\s*(.*)$/', $cleanLine, $m)) {
                $isHeader = true;
                $title = trim($m[1]);
                $techStack = trim($m[2]);
            } elseif (str_ends_with($cleanLine, ':') && strlen($cleanLine) < 70) {
                $isHeader = true;
                $title = rtrim(trim($cleanLine), ':');
            } elseif (!str_contains($cleanLine, '.') && strlen($cleanLine) < 60) {
                $isHeader = true;
                $title = trim($cleanLine);
            }

            if ($isHeader || $current === null) {
                if ($current) {
                    $projects[] = $current;
                }
                $current = [
                    'title' => $title,
                    'tech_stack' => $techStack,
                    'bullets' => [],
                ];
            } else {
                $current['bullets'][] = ucfirst($cleanLine);
            }
        }

        if ($current) {
            $projects[] = $current;
        }

        $formattedBlocks = [];
        foreach ($projects as $p) {
            $header = $p['title'] . (!empty($p['tech_stack']) ? " — {$p['tech_stack']}" : "");
            $bulletStr = !empty($p['bullets']) ? "- " . implode("\n- ", $p['bullets']) : "- Implemented key features and system architecture.";
            $formattedBlocks[] = "{$header}\n{$bulletStr}";
        }

        return implode("\n\n", $formattedBlocks);
    }

    public function buildFallbackFieldSuggestions(array $userInput, array $ragContext): array
    {
        $suggestions = [];

        $name = trim($userInput['fullName'] ?? '');
        if (!empty($name)) {
            $properName = ucwords(strtolower($name));
            if ($properName !== $name) {
                $suggestions['fullName'] = [
                    'field' => 'fullName',
                    'severity' => 'info',
                    'title' => 'Name Capitalization',
                    'reason' => 'Standardize capitalization for candidate name.',
                    'original' => $name,
                    'suggested' => $properName,
                    'can_apply' => true,
                ];
            }
        }

        $headline = trim($userInput['headlineTitle'] ?? '');
        if (!empty($headline)) {
            $headlineLower = strtolower($headline);
            $cleanHeadline = $this->fixCommonTypos($headline);
            if ($cleanHeadline !== $headline || str_contains($headlineLower, 'fresher') || strlen($headline) < 25 || $headline === $headlineLower) {
                $suggestedHeadline = ucwords($cleanHeadline);
                
                $suggestions['headlineTitle'] = [
                    'field' => 'headlineTitle',
                    'severity' => 'warning',
                    'title' => 'Headline ATS Enhancement',
                    'reason' => 'Fix capitalization and spelling typos in your professional headline.',
                    'original' => $headline,
                    'suggested' => $suggestedHeadline,
                    'can_apply' => true,
                ];
            }
        }

        $summary = trim($userInput['experienceSummary'] ?? '');
        if (!empty($summary)) {
            $summaryLower = strtolower($summary);
            if (str_contains($summaryLower, 'fresher') || str_contains($summaryLower, 'know') || strlen($summary) < 60 || str_contains($summaryLower, 'enginer') || str_contains($summaryLower, 'intrested')) {
                $candidateSkills = !empty($userInput['skillsInput']) ? str_replace("\n", ', ', $userInput['skillsInput']) : 'modern tools & practices';
                $targetDomain = !empty($userInput['headlineTitle']) ? ucwords(strtolower($this->fixCommonTypos($userInput['headlineTitle']))) : 'Professional';
                
                $suggestedSummary = "Detail-oriented {$targetDomain} candidate with hands-on experience in {$candidateSkills}. Skilled in technical problem solving and project implementation. Seeking an entry-level position to apply technical expertise and contribute to team goals.";

                $suggestions['experienceSummary'] = [
                    'field' => 'experienceSummary',
                    'severity' => 'critical',
                    'title' => 'Informal Professional Summary',
                    'reason' => 'Transform informal wording into a strong professional summary highlighting your target role (' . $targetDomain . ').',
                    'original' => $summary,
                    'suggested' => $this->fixCommonTypos($suggestedSummary),
                    'can_apply' => true,
                ];
            }
        }

        $eduRaw = trim($userInput['educationRaw'] ?? '');
        if (!empty($eduRaw)) {
            if (!str_contains($eduRaw, '|') && !str_contains($eduRaw, '–')) {
                $lines = array_values(array_filter(array_map('trim', explode("\n", $eduRaw))));
                $degree = 'B.E. Computer Science and Engineering';
                $college = '';
                $cgpa = '';
                $year = '';

                foreach ($lines as $line) {
                    $lineLower = strtolower($line);
                    if (str_contains($lineLower, 'b.e') || str_contains($lineLower, 'b e') || str_contains($lineLower, 'btech') || str_contains($lineLower, 'b.tech') || str_contains($lineLower, 'b.des')) {
                        $degree = ucwords(strtolower($this->fixCommonTypos($line)));
                        $degree = str_replace(['B E ', 'B.e.', 'B Des'], ['B.E. ', 'B.E. ', 'B.Des '], $degree);
                    } elseif (str_contains($lineLower, 'cgpa') || str_contains($lineLower, 'gpa') || preg_match('/\b\d\.\d\b/', $line)) {
                        $cgpa = $line;
                    } elseif (preg_match('/\b(20\d\d)\b/', $line, $ym)) {
                        $year = $ym[1];
                    } else {
                        $college = ucwords(strtolower($line));
                    }
                }

                $eduParts = [$degree];
                if (!empty($college)) $eduParts[] = $college;
                if (!empty($cgpa)) $eduParts[] = (str_contains(strtolower($cgpa), 'cgpa') ? $cgpa : "CGPA: {$cgpa}");
                if (!empty($year)) $eduParts[] = "Expected: {$year}";

                $suggestions['educationRaw'] = [
                    'field' => 'educationRaw',
                    'severity' => 'warning',
                    'title' => 'Education Formatting',
                    'reason' => 'Format your education details into a single clean ATS line preserving exact college and CGPA.',
                    'original' => $eduRaw,
                    'suggested' => implode(' | ', $eduParts),
                    'can_apply' => true,
                ];
            }
        }

        $skillsRaw = trim($userInput['skillsInput'] ?? '');
        if (!empty($skillsRaw)) {
            if (!str_contains($skillsRaw, ':')) {
                $rawItems = array_filter(array_map('trim', explode(',', str_replace(["\n", ';'], ',', $skillsRaw))));
                $designTools = [];
                $designMethods = [];
                $techSkills = [];

                foreach ($rawItems as $item) {
                    $clean = trim($item);
                    $lower = strtolower($clean);

                    if (in_array($lower, ['figma', 'adobe xd', 'photoshop', 'illustrator', 'sketch', 'invision'])) {
                        $designTools[] = ucwords($clean);
                    } elseif (in_array($lower, ['wireframing', 'prototyping', 'user research', 'usability testing', 'design systems', 'user flows', 'information architecture'])) {
                        $designMethods[] = ucwords($clean);
                    } else {
                        $techSkills[] = ucwords($clean);
                    }
                }

                $categorizedLines = [];
                if (!empty($designTools)) $categorizedLines[] = 'Design Tools: ' . implode(', ', $designTools);
                if (!empty($designMethods)) $categorizedLines[] = 'Design & UX Methods: ' . implode(', ', $designMethods);
                if (!empty($techSkills)) $categorizedLines[] = 'Technical Skills: ' . implode(', ', $techSkills);

                $suggestions['skillsInput'] = [
                    'field' => 'skillsInput',
                    'severity' => 'warning',
                    'title' => 'Categorize & Clean Technical Skills',
                    'reason' => 'Group your exact listed skills into professional ATS categories.',
                    'original' => $skillsRaw,
                    'suggested' => implode("\n", $categorizedLines),
                    'can_apply' => true,
                ];
            }
        }

        $projectsRaw = trim($userInput['projectsRaw'] ?? '');
        if (!empty($projectsRaw)) {
            $suggestions['projectsRaw'] = [
                'field' => 'projectsRaw',
                'severity' => 'warning',
                'title' => 'Projects Enhancement',
                'reason' => 'Structured projects into separate titles, tech stacks, and action-verb bullet points.',
                'original' => $projectsRaw,
                'suggested' => $this->formatProjectsText($projectsRaw),
                'can_apply' => true,
            ];
        }

        $certsRaw = trim($userInput['certificationsRaw'] ?? '');
        if (!empty($certsRaw)) {
            if (!str_contains($certsRaw, '—') && !str_contains($certsRaw, '-')) {
                $lines = array_filter(array_map('trim', explode("\n", $certsRaw)));
                $formattedCerts = array_map(fn($l) => ucwords(strtolower($l)) . ' — Certification', $lines);
                $suggestions['certificationsRaw'] = [
                    'field' => 'certificationsRaw',
                    'severity' => 'info',
                    'title' => 'Certifications Formatting',
                    'reason' => 'Format certification titles with clear issuer / achievement details.',
                    'original' => $certsRaw,
                    'suggested' => implode("\n", $formattedCerts),
                    'can_apply' => true,
                ];
            }
        }

        $soft = trim($userInput['softSkillsInput'] ?? '');
        if (!empty($soft)) {
            $cleanSoft = $this->fixCommonTypos(ucwords(strtolower($soft)));
            $suggestions['softSkillsInput'] = [
                'field' => 'softSkillsInput',
                'severity' => 'info',
                'title' => 'Soft Skills Enhancement',
                'reason' => 'Formatted soft skills in title case with professional terminology.',
                'original' => $soft,
                'suggested' => $cleanSoft,
                'can_apply' => true,
            ];
        }

        $loc = trim($userInput['location'] ?? '');
        if (!empty($loc)) {
            $cleanLoc = $this->fixCommonTypos(ucwords(strtolower($loc)));
            if ($cleanLoc !== $loc || !str_contains($loc, ',')) {
                $suggestions['location'] = [
                    'field' => 'location',
                    'severity' => 'info',
                    'title' => 'Location Format',
                    'reason' => 'Standardized city and state location formatting.',
                    'original' => $loc,
                    'suggested' => $cleanLoc,
                    'can_apply' => true,
                ];
            }
        }

        return $suggestions;
    }
}
