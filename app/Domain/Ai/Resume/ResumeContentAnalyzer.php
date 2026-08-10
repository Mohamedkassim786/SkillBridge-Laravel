<?php

namespace App\Domain\Ai\Resume;

class ResumeContentAnalyzer
{
    /**
     * Map of common technology name misspellings or non-standard variations to standard ATS naming.
     */
    protected array $skillNormalizationMap = [
        'react js' => 'React.js',
        'reactjs' => 'React.js',
        'react.js' => 'React.js',
        'node js' => 'Node.js',
        'nodejs' => 'Node.js',
        'node.js' => 'Node.js',
        'express js' => 'Express.js',
        'expressjs' => 'Express.js',
        'express.js' => 'Express.js',
        'vue js' => 'Vue.js',
        'vuejs' => 'Vue.js',
        'vue.js' => 'Vue.js',
        'next js' => 'Next.js',
        'nextjs' => 'Next.js',
        'next.js' => 'Next.js',
        'postgre sql' => 'PostgreSQL',
        'postgresql' => 'PostgreSQL',
        'postgres' => 'PostgreSQL',
        'mongo db' => 'MongoDB',
        'mongodb' => 'MongoDB',
        'my sql' => 'MySQL',
        'mysql' => 'MySQL',
        'java script' => 'JavaScript',
        'javascript' => 'JavaScript',
        'type script' => 'TypeScript',
        'typescript' => 'TypeScript',
        'git hub' => 'GitHub',
        'github' => 'GitHub',
        'tailwind css' => 'Tailwind CSS',
        'tailwindcss' => 'Tailwind CSS',
        'html 5' => 'HTML5',
        'html5' => 'HTML5',
        'css 3' => 'CSS3',
        'css3' => 'CSS3',
        'spring boot' => 'Spring Boot',
        'springboot' => 'Spring Boot',
        'c ++' => 'C++',
        'c #' => 'C#',
        'dot net' => '.NET',
        'dotnet' => '.NET',
        'amazon web services' => 'AWS',
        'express' => 'Express.js',
        'bootstrap' => 'Bootstrap',
        'postman' => 'Postman',
        'vs code' => 'VS Code',
        'vscode' => 'VS Code',
        'socket io' => 'Socket.IO',
        'socketio' => 'Socket.IO',
        'rest api' => 'REST APIs',
        'rest apis' => 'REST APIs',
        'restful api' => 'REST APIs',
    ];

    /**
     * Category mapping rules for ATS skill organization.
     */
    protected array $skillCategoryRules = [
        'Programming Languages' => ['javascript', 'typescript', 'python', 'java', 'c', 'c++', 'c#', 'php', 'go', 'golang', 'rust', 'ruby', 'kotlin', 'swift'],
        'Frontend' => ['html', 'html5', 'css', 'css3', 'react.js', 'react', 'react router', 'redux', 'tailwind css', 'bootstrap', 'material ui', 'jquery', 'angular', 'vue.js', 'vue', 'next.js', 'nextjs', 'svelte'],
        'Backend' => ['node.js', 'express.js', 'laravel', 'django', 'flask', 'spring boot', 'asp.net', 'rest apis', 'graphql', 'jwt', 'websockets', 'socket.io'],
        'Databases' => ['postgresql', 'mysql', 'mongodb', 'redis', 'sqlite', 'oracle', 'mariadb', 'firebase firestore', 'dynamodb', 'sql', 'prisma'],
        'Cloud & DevOps' => ['aws', 'azure', 'google cloud', 'gcp', 'docker', 'kubernetes', 'ci/cd', 'jenkins', 'github actions', 'linux', 'nginx'],
        'Tools' => ['git', 'github', 'gitlab', 'vs code', 'postman', 'figma', 'jira', 'npm', 'yarn', 'webpack', 'vite'],
        'Testing' => ['jest', 'cypress', 'selenium', 'junit', 'pytest', 'postman testing', 'phpunit'],
        'Mobile' => ['flutter', 'react native', 'android', 'android studio', 'swiftui', 'kotlin android', 'ios'],
    ];

    /**
     * Common typo replacements for general English text.
     */
    protected array $typoMap = [
        '/\bpassionated\b/i' => 'passionate',
        '/\bdevelopement\b/i' => 'development',
        '/\bknowlege\b/i' => 'knowledge',
        '/\benginer\b/i' => 'Engineer',
        '/\benginering\b/i' => 'Engineering',
        '/\bengineerng\b/i' => 'Engineering',
        '/\bdesiner\b/i' => 'Designer',
        '/\bdesgin\b/i' => 'Design',
        '/\bdevlopor\b/i' => 'Developer',
        '/\bdevloper\b/i' => 'Developer',
        '/\bexperiance\b/i' => 'Experience',
        '/\boppurtunity\b/i' => 'Opportunity',
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

    /**
     * Categorize a raw skills text or array into a structured map of categories -> skill lists.
     */
    public function categorizeSkillsToMap($skillsInput): array
    {
        if (is_array($skillsInput)) {
            $flat = [];
            foreach ($skillsInput as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $sub) $flat[] = (string) $sub;
                } else {
                    $flat[] = (string) $v;
                }
            }
            $skillsInput = implode(', ', $flat);
        }

        if (empty(trim((string) $skillsInput))) {
            return [];
        }

        $lines = explode("\n", (string) $skillsInput);
        $categorized = [];
        $addedSkills = [];
        $currentContextCategory = null;

        // Known header patterns to recognize category lines and ignore header words
        $headerPatterns = [
            '/^(programming\s+languages|languages)$/i' => 'Programming Languages',
            '/^(frontend\s+technologies|frontend)$/i' => 'Frontend',
            '/^(backend\s+technologies|backend)$/i' => 'Backend',
            '/^(databases|database\s+technologies)$/i' => 'Databases',
            '/^(cloud\s+and\s+devops|cloud\s+&\s+devops|cloud\s+devops|cloud|devops)$/i' => 'Cloud & DevOps',
            '/^(tools|developer\s+tools|other\s+tools)$/i' => 'Tools',
            '/^(testing|qa\s+and\s+testing|qa)$/i' => 'Testing',
            '/^(mobile|mobile\s+development)$/i' => 'Mobile',
            '/^(other\s+technologies|other\s+skills|others)$/i' => 'Other Technologies',
        ];

        foreach ($lines as $line) {
            $lineTrim = trim($line);
            if (empty($lineTrim)) continue;

            $detectedHeader = null;
            $skillsStr = $lineTrim;

            if (str_contains($lineTrim, ':')) {
                $parts = explode(':', $lineTrim, 2);
                $headerCandidate = trim($parts[0]);
                $skillsStr = trim($parts[1]);

                foreach ($headerPatterns as $pattern => $catName) {
                    if (preg_match($pattern, $headerCandidate)) {
                        $detectedHeader = $catName;
                        break;
                    }
                }
                if (!$detectedHeader) {
                    $detectedHeader = ucwords(strtolower($headerCandidate));
                }
            } else {
                // Line without colon: check if the entire line is a standalone category header
                foreach ($headerPatterns as $pattern => $catName) {
                    if (preg_match($pattern, $lineTrim)) {
                        $detectedHeader = $catName;
                        $skillsStr = ''; // Line is header only, no skills
                        break;
                    }
                }
            }

            if ($detectedHeader) {
                $currentContextCategory = $detectedHeader;
            }

            if (empty($skillsStr)) continue;

            $items = array_filter(array_map('trim', explode(',', $skillsStr)));
            foreach ($items as $item) {
                if (empty($item)) continue;

                // Skip header words from being added as skill items
                $isHeaderWord = false;
                foreach ($headerPatterns as $pattern => $catName) {
                    if (preg_match($pattern, $item)) {
                        $isHeaderWord = true;
                        break;
                    }
                }
                if ($isHeaderWord) continue;

                $lower = strtolower($item);
                $normalizedName = $this->skillNormalizationMap[$lower] ?? $item;
                $lowerNorm = strtolower($normalizedName);

                if (in_array($lowerNorm, $addedSkills)) {
                    continue; // Skip exact duplicates
                }

                // Determine category for this skill item
                $matchedCategory = null;
                foreach ($this->skillCategoryRules as $catName => $keywords) {
                    if (in_array($lowerNorm, $keywords) || in_array($lower, $keywords)) {
                        $matchedCategory = $catName;
                        break;
                    }
                }

                // Fallback to active context category if no keyword rule matched
                if (!$matchedCategory) {
                    $matchedCategory = $currentContextCategory ?: 'Other Technologies';
                }

                $categorized[$matchedCategory][] = $normalizedName;
                $addedSkills[] = $lowerNorm;
            }
        }

        return array_filter($categorized, fn($list) => count($list) > 0);
    }

    /**
     * Normalize skill names in a text input into categorized ATS multiline format.
     */
    public function normalizeSkills(string $skillsInput): string
    {
        if (empty(trim($skillsInput))) {
            return '';
        }

        $map = $this->categorizeSkillsToMap($skillsInput);
        $lines = [];

        foreach ($map as $cat => $skills) {
            if (!empty($skills)) {
                $lines[] = "{$cat}: " . implode(', ', array_unique($skills));
            }
        }

        return implode("\n", $lines);
    }

    /**
     * Normalize a list of technologies into a single clean comma-separated string (for project tech stacks).
     */
    public function normalizeTechList(string $techInput): string
    {
        if (empty(trim($techInput))) {
            return '';
        }

        $items = array_filter(array_map('trim', explode(',', $techInput)));
        $normalized = [];
        foreach ($items as $item) {
            $lower = strtolower($item);
            $norm = $this->skillNormalizationMap[$lower] ?? $item;
            if (!in_array(strtolower($norm), array_map('strtolower', $normalized))) {
                $normalized[] = $norm;
            }
        }

        return implode(', ', $normalized);
    }

    /**
     * Fix common typos and spelling errors in raw text.
     */
    public function fixTypos(string $text): string
    {
        if (empty(trim($text))) {
            return '';
        }

        return preg_replace(array_keys($this->typoMap), array_values($this->typoMap), $text);
    }

    /**
     * Normalize city and state location formatting.
     * Example: "Chennai,Tamilnadu" -> "Chennai, Tamil Nadu"
     */
    public function normalizeLocation(string $location): string
    {
        $loc = trim($location);
        if (empty($loc)) return '';

        $loc = $this->fixTypos($loc);
        if (str_contains($loc, ',')) {
            $parts = array_map('trim', explode(',', $loc, 2));
            return ucwords(strtolower($parts[0])) . ', ' . ucwords(strtolower($parts[1]));
        }

        return ucwords(strtolower($loc));
    }

    /**
     * Normalize headline formatting (3-8 words, title case).
     */
    public function normalizeHeadline(string $headline): string
    {
        $clean = trim($this->fixTypos($headline));
        if (empty($clean)) return '';

        $words = explode(' ', $clean);
        $capitalized = array_map(function ($w) {
            $lower = strtolower($w);
            if (isset($this->skillNormalizationMap[$lower])) {
                return $this->skillNormalizationMap[$lower];
            }
            if (in_array($lower, ['and', 'in', 'with', 'for', 'of', 'at', 'on', 'to', 'a', 'an'])) {
                return strtolower($w);
            }
            return ucfirst($w);
        }, $words);

        return implode(' ', $capitalized);
    }

    /**
     * Validate email format locally.
     */
    public function isValidEmail(string $email): bool
    {
        return filter_var(trim($email), FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Validate phone number format locally.
     */
    public function isValidPhone(string $phone): bool
    {
        $clean = preg_replace('/[^\d\+]/', '', trim($phone));
        return strlen($clean) >= 7;
    }

    /**
     * Validate URL format locally.
     */
    public function isValidUrl(string $url): bool
    {
        $trimmed = trim($url);
        if (empty($trimmed)) return true;
        return str_starts_with($trimmed, 'http://') || str_starts_with($trimmed, 'https://');
    }
}
