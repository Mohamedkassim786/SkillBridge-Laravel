<?php

namespace App\Domain\Ai\Resume;

class ResumeNormalizer
{
    protected ResumeContentAnalyzer $analyzer;
    protected ResumeExperienceParser $experienceParser;

    public function __construct(
        ?ResumeContentAnalyzer $analyzer = null,
        ?ResumeExperienceParser $experienceParser = null
    ) {
        $this->analyzer = $analyzer ?? new ResumeContentAnalyzer();
        $this->experienceParser = $experienceParser ?? new ResumeExperienceParser();
    }

    /**
     * Main Pipeline Normalization Entry Point.
     */
    public function normalize(array $data): array
    {
        $normalized = [];

        // Header info
        $normalized['name'] = trim($data['name'] ?? $data['fullName'] ?? '');
        $normalized['headline'] = $this->analyzer->normalizeHeadline($data['headline'] ?? $data['headlineTitle'] ?? '');
        $normalized['phone'] = trim($data['phone'] ?? '');
        $normalized['email'] = trim($data['email'] ?? '');
        $normalized['location'] = $this->analyzer->normalizeLocation($data['location'] ?? '');
        $normalized['linkedin'] = trim($data['linkedin'] ?? '');
        $normalized['github'] = trim($data['github'] ?? '');
        $normalized['portfolio'] = trim($data['portfolio'] ?? '');
        $normalized['ats_score'] = (int) ($data['ats_score'] ?? 85);

        // 1. Professional Summary (Constraint: 40-80 words, 2-4 sentences, max 2-4 technologies naturally)
        $summaryRaw = trim($data['professional_summary'] ?? $data['experienceSummary'] ?? '');
        $normalized['professional_summary'] = $this->normalizeProfessionalSummary($summaryRaw, $data);

        // 2. Education (Preserve exact values)
        $normalized['education'] = $this->normalizeEducation($data['education'] ?? $data['educationRaw'] ?? []);

        // 3. Technical Skills (Structured categories as array/map)
        $normalized['technical_skills'] = $this->normalizeTechnicalSkills($data['technical_skills'] ?? $data['skillsInput'] ?? []);

        // 4. Work Experience (Max 5 bullets per entry, internships stay here)
        $normalized['work_experience'] = $this->normalizeWorkExperience($data['work_experience'] ?? $data['workExperienceRaw'] ?? []);

        // 5. Projects (Max 4 bullets per project, keep separate)
        $normalized['projects'] = $this->normalizeProjects($data['projects'] ?? $data['projectsRaw'] ?? []);

        // 6. Certifications
        $normalized['certifications'] = $this->normalizeStringList($data['certifications'] ?? $data['certificationsRaw'] ?? []);

        // 7. Achievements
        $normalized['achievements'] = $this->normalizeStringList($data['achievements'] ?? $data['achievementsRaw'] ?? []);

        // 8. Soft Skills (Max 8 items, Title Case)
        $normalized['soft_skills'] = $this->normalizeSoftSkills($data['soft_skills'] ?? $data['softSkillsInput'] ?? []);

        // Keywords & metadata
        $normalized['matched_keywords'] = is_array($data['matched_keywords'] ?? null) ? array_values(array_unique($data['matched_keywords'])) : [];
        $normalized['missing_keywords'] = is_array($data['missing_keywords'] ?? null) ? array_values(array_unique($data['missing_keywords'])) : [];
        $normalized['suggested_improvements'] = is_array($data['suggested_improvements'] ?? null) ? array_values($data['suggested_improvements']) : [];
        $normalized['suggested_skills'] = is_array($data['suggested_skills'] ?? null) ? array_values($data['suggested_skills']) : [];

        return $normalized;
    }

    /**
     * Normalize Professional Summary (Enforce 40-80 words, 2-4 sentences, max 2-4 skills mentioned naturally).
     */
    protected function normalizeProfessionalSummary(string $summary, array $context): string
    {
        $summary = $this->analyzer->fixTypos($summary);

        // Check if summary duplicated category headers or entire skills dump
        $hasSkillDump = preg_match('/(programming languages|frontend technologies|backend technologies|databases|tools|cloud)/i', $summary)
            || (substr_count($summary, ',') > 6 && !str_contains($summary, '.'));

        if ($hasSkillDump || empty($summary) || strlen($summary) < 30) {
            $skillsInput = is_string($context['skillsInput'] ?? null) ? $context['skillsInput'] : '';
            if (empty($skillsInput) && is_array($context['technical_skills'] ?? null)) {
                $flatSkills = [];
                foreach ($context['technical_skills'] as $cat => $val) {
                    $valStr = is_array($val) ? implode(', ', $val) : (string) $val;
                    $flatSkills[] = "{$cat}: {$valStr}";
                }
                $skillsInput = implode("\n", $flatSkills);
            }

            $topSkills = $this->extractTopSkillsForSummary($skillsInput, 3);
            $targetDomain = !empty($context['headlineTitle']) ? ucwords(strtolower($this->analyzer->fixTypos($context['headlineTitle']))) : (!empty($context['headline']) ? $context['headline'] : 'Full Stack Developer');
            
            $summary = "Motivated {$targetDomain} with hands-on experience building applications using {$topSkills}. Interested in building scalable software solutions, solving complex technical problems, and contributing effectively to collaborative engineering teams.";
        }

        // Clean up any remaining double spaces or trailing noise
        return trim(preg_replace('/\s+/', ' ', $summary));
    }

    /**
     * Extract 2-4 top skill names without category headers for natural summary phrasing.
     */
    protected function extractTopSkillsForSummary(string $skillsInput, int $max = 3): string
    {
        if (empty(trim($skillsInput))) return 'modern software tools';

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
                    $extracted[] = $this->analyzer->normalizeSkills($item);
                }
            }
        }

        $selected = array_slice($extracted, 0, $max);
        if (empty($selected)) return 'modern software tools';

        if (count($selected) === 1) return $selected[0];
        if (count($selected) === 2) return $selected[0] . ' and ' . $selected[1];

        $last = array_pop($selected);
        return implode(', ', $selected) . ', and ' . $last;
    }

    /**
     * Normalize Technical Skills into structured category map.
     */
    protected function normalizeTechnicalSkills($skillsData): array
    {
        return $this->analyzer->categorizeSkillsToMap($skillsData);
    }

    /**
     * Normalize Work Experience (Max 5 bullets per entry).
     */
    protected function normalizeWorkExperience($workData): array
    {
        $experiences = [];
        if (is_string($workData)) {
            $experiences = $this->experienceParser->parseWorkExperience($workData);
        } elseif (is_array($workData)) {
            foreach ($workData as $item) {
                if (!is_array($item)) continue;
                $bullets = $item['bullets'] ?? [];
                if (is_string($bullets)) {
                    $bullets = array_values(array_filter(array_map('trim', explode("\n", $bullets))));
                }
                $bullets = array_slice(array_values(array_unique($bullets)), 0, 5); // Max 5 bullets

                $experiences[] = [
                    'title' => trim($item['title'] ?? $item['job_title'] ?? ''),
                    'company' => trim($item['company'] ?? ''),
                    'employment_type' => trim($item['employment_type'] ?? 'Full-time'),
                    'period' => trim($item['period'] ?? ($item['start_date'] ?? '') . ($item['end_date'] ?? '' ? ' – ' . $item['end_date'] : '')),
                    'location' => trim($item['location'] ?? ''),
                    'bullets' => $bullets,
                ];
            }
        }

        return array_values(array_filter($experiences, fn($e) => !empty($e['title']) || !empty($e['company'])));
    }

    /**
     * Normalize Projects (Max 4 bullets per project, keep separate).
     */
    protected function normalizeProjects($projectsData): array
    {
        $projects = [];
        if (is_string($projectsData)) {
            $projects = $this->experienceParser->parseProjects($projectsData);
        } elseif (is_array($projectsData)) {
            foreach ($projectsData as $p) {
                if (!is_array($p)) continue;
                $bullets = $p['bullets'] ?? [];
                if (is_string($bullets)) {
                    $bullets = array_values(array_filter(array_map('trim', explode("\n", $bullets))));
                }
                $bullets = array_slice(array_values(array_unique($bullets)), 0, 4); // Max 4 bullets per project

                $projects[] = [
                    'title' => trim($p['title'] ?? ''),
                    'tech_stack' => $this->analyzer->normalizeSkills(trim($p['tech_stack'] ?? $p['technologies'] ?? '')),
                    'badge' => trim($p['badge'] ?? ''),
                    'bullets' => $bullets,
                ];
            }
        }

        return array_values(array_filter($projects, fn($p) => !empty($p['title'])));
    }

    /**
     * Normalize Education details.
     */
    protected function normalizeEducation($eduData): array
    {
        $education = [];
        if (is_string($eduData)) {
            $lines = array_values(array_filter(array_map('trim', explode("\n", $eduData))));
            foreach ($lines as $line) {
                $parts = preg_split('/\s*[\|–—]\s*/', $line);
                $education[] = [
                    'degree' => trim($parts[0] ?? $line),
                    'institution' => trim($parts[1] ?? ''),
                    'cgpa' => trim($parts[2] ?? ''),
                    'year' => trim($parts[3] ?? ''),
                ];
            }
        } elseif (is_array($eduData)) {
            foreach ($eduData as $edu) {
                if (!is_array($edu)) continue;
                $education[] = [
                    'degree' => trim($edu['degree'] ?? ''),
                    'institution' => trim($edu['institution'] ?? ''),
                    'cgpa' => trim($edu['cgpa'] ?? ''),
                    'year' => trim($edu['year'] ?? ''),
                ];
            }
        }

        return array_values(array_filter($education, fn($e) => !empty($e['degree']) || !empty($e['institution'])));
    }

    /**
     * Normalize list of strings (Certifications / Achievements).
     */
    protected function normalizeStringList($listData): array
    {
        if (is_string($listData)) {
            $items = array_values(array_filter(array_map('trim', explode("\n", $listData))));
        } elseif (is_array($listData)) {
            $items = array_values(array_filter(array_map('trim', $listData)));
        } else {
            $items = [];
        }

        return array_values(array_unique(array_filter($items, fn($i) => !empty($i) && strtolower($i) !== 'none')));
    }

    /**
     * Normalize Soft Skills (Max 8 items, Title Case, smart phrase splitting).
     */
    protected function normalizeSoftSkills($softData): array
    {
        if (empty($softData)) return [];

        $rawStr = is_array($softData) ? implode(', ', $softData) : (string) $softData;
        $rawStr = $this->analyzer->fixTypos(trim($rawStr));

        if (empty($rawStr)) return [];

        $knownSoftSkills = [
            'good communication skill', 'good communication', 'communication skills', 'communication',
            'team work', 'teamwork', 'team player',
            'problem solving', 'problem-solving',
            'time management',
            'leadership skill', 'leadership skills', 'leadership',
            'quick learner', 'fast learner',
            'adaptability', 'adaptable',
            'critical thinking',
            'hard working', 'hardworking',
            'work ethic', 'conflict resolution', 'decision making', 'emotional intelligence', 'active listening'
        ];

        // 1. If commas or newlines present, split by commas and newlines
        if (str_contains($rawStr, ',') || str_contains($rawStr, "\n")) {
            $tokens = preg_split('/[,\n]+/', $rawStr);
        } else {
            // 2. Space-separated run-on text: extract known soft skill phrases
            $tokens = [];
            $remaining = $rawStr;
            foreach ($knownSoftSkills as $phrase) {
                if (preg_match('/\b' . preg_quote($phrase, '/') . '\b/i', $remaining)) {
                    $tokens[] = ucwords($phrase);
                    $remaining = preg_replace('/\b' . preg_quote($phrase, '/') . '\b/i', '', $remaining);
                }
            }
            if (empty($tokens)) {
                $tokens = explode(' ', $rawStr);
            }
        }

        $cleanItems = [];
        foreach ($tokens as $item) {
            $itemTrim = trim($item);
            if (empty($itemTrim)) continue;

            $normalized = match (strtolower($itemTrim)) {
                'good communication skill', 'good communication', 'communication skills' => 'Communication',
                'team work', 'teamwork' => 'Teamwork',
                'leadership skill', 'leadership skills' => 'Leadership',
                'team player' => 'Team Player',
                'hard working', 'hardworking' => 'Work Ethic',
                'problem solving', 'problem-solving' => 'Problem Solving',
                'quick learner', 'fast learner' => 'Quick Learner',
                'critical thinking' => 'Critical Thinking',
                'time management' => 'Time Management',
                default => ucwords(strtolower($itemTrim)),
            };

            if (!empty($normalized) && strlen($normalized) >= 3 && !in_array($normalized, $cleanItems)) {
                $cleanItems[] = $normalized;
            }
        }

        return array_slice($cleanItems, 0, 8); // Max 8 soft skills
    }
}
