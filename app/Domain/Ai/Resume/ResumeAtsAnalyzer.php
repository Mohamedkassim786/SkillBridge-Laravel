<?php

namespace App\Domain\Ai\Resume;

class ResumeAtsAnalyzer
{
    /**
     * Common domain keyword clusters for quick ATS matching.
     */
    protected array $keywordClusters = [
        'fullstack' => ['react', 'node', 'express', 'javascript', 'typescript', 'postgresql', 'mongodb', 'html', 'css', 'git', 'rest api'],
        'frontend' => ['react', 'vue', 'angular', 'javascript', 'typescript', 'html5', 'css3', 'tailwind', 'redux', 'figma'],
        'backend' => ['node.js', 'python', 'java', 'spring boot', 'laravel', 'php', 'postgresql', 'mysql', 'docker', 'redis', 'restful api'],
        'data' => ['python', 'sql', 'pandas', 'numpy', 'scikit-learn', 'power bi', 'tableau', 'excel', 'data analysis', 'machine learning'],
    ];

    /**
     * Analyze candidate content against a target job description.
     */
    public function analyzeAtsMatch(string $candidateSkills, string $candidateSummary, string $jobDescription): array
    {
        $jobText = strtolower(trim($jobDescription));
        if (empty($jobText)) {
            $jobText = 'software developer full stack web development react node postgresql git';
        }

        $combinedCandidate = strtolower($candidateSkills . ' ' . $candidateSummary);
        
        // Extract technical words from job description
        preg_match_all('/\b[a-z0-9\.\+#]{2,15}\b/', $jobText, $m);
        $jobWords = array_unique($m[0] ?? []);

        // Filter tech keywords
        $techKeywords = array_filter($jobWords, function ($word) {
            return in_array($word, [
                'react', 'node', 'express', 'vue', 'angular', 'python', 'java', 'php', 'laravel',
                'javascript', 'typescript', 'html', 'css', 'sql', 'postgresql', 'mysql', 'mongodb',
                'docker', 'aws', 'git', 'github', 'rest', 'api', 'microservices', 'spring', 'redux',
                'tailwind', 'bootstrap', 'figma', 'redis', 'graphql', 'kubernetes', 'ci/cd', 'agile'
            ]);
        });

        if (empty($techKeywords)) {
            $techKeywords = ['react', 'node', 'javascript', 'sql', 'git'];
        }

        $matched = [];
        $missing = [];

        foreach ($techKeywords as $kw) {
            if (str_contains($combinedCandidate, $kw)) {
                $matched[] = ucfirst($kw);
            } else {
                $missing[] = ucfirst($kw);
            }
        }

        $matchedCount = count($matched);
        $totalCount = max(1, count($techKeywords));
        $matchRatio = $matchedCount / $totalCount;
        
        // Estimated ATS Score (Range: 60% - 95%)
        $score = min(96, max(60, (int) round(60 + ($matchRatio * 35))));

        $recommendations = [];
        if (!empty($missing)) {
            $missingStr = implode(', ', array_slice($missing, 0, 4));
            $recommendations[] = "If you have practical experience with {$missingStr}, consider including them in your Technical Skills or Projects.";
        }
        $recommendations[] = "Use action verbs (e.g., Developed, Engineered, Designed) at the start of every project bullet point.";
        $recommendations[] = "Ensure your contact details and professional headline are formatted cleanly at the top of your resume.";

        return [
            'ats_score' => $score,
            'matched_keywords' => array_values(array_unique($matched)),
            'missing_keywords' => array_values(array_unique($missing)),
            'recommendations' => $recommendations,
        ];
    }
}
