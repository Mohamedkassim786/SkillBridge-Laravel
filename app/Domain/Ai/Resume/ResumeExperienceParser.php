<?php

namespace App\Domain\Ai\Resume;

class ResumeExperienceParser
{
    protected ResumeContentAnalyzer $contentAnalyzer;

    public function __construct(?ResumeContentAnalyzer $contentAnalyzer = null)
    {
        $this->contentAnalyzer = $contentAnalyzer ?? app(ResumeContentAnalyzer::class);
    }
    /**
     * Parse raw Work Experience textarea string into structured array.
     */
    public function parseWorkExperience(string $rawText): array
    {
        $rawText = trim($rawText);
        if (empty($rawText)) return [];

        $lines = array_values(array_filter(array_map('trim', explode("\n", $rawText))));
        $experiences = [];
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

            // Check if line is a header (Title — Company | Period | EmploymentType)
            $isHeader = false;
            $title = $cleanLine;
            $company = '';
            $period = '';
            $employmentType = 'Full-time';
            $location = '';

            if (str_contains(strtolower($cleanLine), 'intern') || str_contains(strtolower($cleanLine), 'internship')) {
                $employmentType = 'Internship';
            } elseif (str_contains(strtolower($cleanLine), 'contract')) {
                $employmentType = 'Contract';
            } elseif (str_contains(strtolower($cleanLine), 'freelance')) {
                $employmentType = 'Freelance';
            } elseif (str_contains(strtolower($cleanLine), 'part-time') || str_contains(strtolower($cleanLine), 'part time')) {
                $employmentType = 'Part-time';
            }

            if (preg_match('/^(.*?)\s*(?:—|–|\|)\s*(.*)$/', $cleanLine, $m)) {
                $isHeader = true;
                $title = trim($m[1]);
                $rest = trim($m[2]);

                if (str_contains($rest, '|')) {
                    $parts = array_map('trim', explode('|', $rest));
                    $company = $parts[0] ?? '';
                    $period = $parts[1] ?? '';
                    if (isset($parts[2])) $location = $parts[2];
                } else {
                    $company = $rest;
                }
            } elseif (!str_contains($cleanLine, '.') && strlen($cleanLine) < 80) {
                $isHeader = true;
                $title = trim($cleanLine);
            }

            if ($isHeader || $current === null) {
                if ($current) {
                    $experiences[] = $current;
                }
                $current = [
                    'title' => $title,
                    'company' => $company,
                    'employment_type' => $employmentType,
                    'period' => $period,
                    'location' => $location,
                    'bullets' => [],
                ];
            } else {
                $current['bullets'][] = ucfirst($cleanLine);
            }
        }

        if ($current) {
            $experiences[] = $current;
        }

        return $experiences;
    }

    /**
     * Parse raw Projects textarea string into structured array.
     */
    public function parseProjects(string $rawText): array
    {
        $rawText = trim($rawText);
        if (empty($rawText)) return [];

        $lines = array_values(array_filter(array_map('trim', explode("\n", $rawText))));
        $projects = [];
        $current = null;
        $awaitingTechStack = false;

        foreach ($lines as $line) {
            $cleanLine = trim($line);
            if (empty($cleanLine)) continue;

            // 1. Technologies line handling (e.g. "Technologies:", "Technologies", "Tech Stack:")
            if (preg_match('/^(technologies|tech\s+stack)\s*:?\s*(.*)$/i', $cleanLine, $tm)) {
                $inlineTech = trim($tm[2]);
                if (!empty($inlineTech)) {
                    if ($current) {
                        $current['tech_stack'] = $this->contentAnalyzer->normalizeTechList($inlineTech);
                    }
                    $awaitingTechStack = false;
                } else {
                    $awaitingTechStack = true;
                }
                continue;
            }

            if ($awaitingTechStack) {
                if ($current && empty($current['tech_stack'])) {
                    $current['tech_stack'] = $this->contentAnalyzer->normalizeTechList($cleanLine);
                }
                $awaitingTechStack = false;
                continue;
            }

            // 2. Check if explicit bullet point (- or • or *)
            $isExplicitBullet = preg_match('/^\s*[\-\•\*]\s*/', $cleanLine);
            if ($isExplicitBullet) {
                $bulletText = preg_replace('/^\s*[\-\•\*]\s*/', '', $cleanLine);
                if ($current) {
                    $current['bullets'][] = ucfirst(rtrim($bulletText, '.'));
                }
                continue;
            }

            // 3. Action verb check
            $isActionVerb = preg_match('/^(developed|created|implemented|built|designed|used|added|integrated|worked|maintained|managed|optimized|automated|configured|deployed|tested|spearheaded|architected)\b/i', $cleanLine);

            // 4. Header Detection
            $isHeader = false;
            $title = $cleanLine;
            $techStack = '';

            if (preg_match('/^(.*?)\s*(?:—|–|\|)\s*(.*)$/', $cleanLine, $m)) {
                $isHeader = true;
                $title = trim($m[1]);
                $techStack = $this->contentAnalyzer->normalizeTechList(trim($m[2]));
            } elseif (!$isActionVerb && !str_contains($cleanLine, '.') && strlen($cleanLine) < 60 && !preg_match('/^(technologies|tech\s+stack)/i', $cleanLine)) {
                if ($current === null || count($current['bullets']) > 0 || !empty($current['tech_stack'])) {
                    $isHeader = true;
                    $title = trim($cleanLine);
                }
            }

            if ($isHeader) {
                if ($current) {
                    $current['bullets'] = array_slice($current['bullets'], 0, 4);
                    $projects[] = $current;
                }
                $current = [
                    'title' => $title,
                    'tech_stack' => $techStack,
                    'badge' => '',
                    'bullets' => [],
                ];
            } else {
                if ($current) {
                    $bCount = count($current['bullets']);
                    $shouldJoinToPrev = false;

                    if ($bCount > 0) {
                        $lastBullet = $current['bullets'][$bCount - 1];
                        if (!preg_match('/[\.\!\?]$/', $lastBullet)) {
                            if (preg_match('/\b(for|and|using|with|in|to|of|on|by|from|teacher|course|user|admin|frontend|backend)\s*$/i', $lastBullet) || !$isActionVerb) {
                                $shouldJoinToPrev = true;
                            }
                        }
                    }

                    if ($shouldJoinToPrev) {
                        $current['bullets'][$bCount - 1] .= ' ' . lcfirst($cleanLine);
                    } else {
                        $current['bullets'][] = ucfirst(rtrim($cleanLine, '.'));
                    }
                }
            }
        }

        if ($current) {
            $current['bullets'] = array_slice($current['bullets'], 0, 4);
            $projects[] = $current;
        }

        return $projects;
    }
}
