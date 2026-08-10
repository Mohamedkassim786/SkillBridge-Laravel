<?php

namespace App\Domain\Ai\Common;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class RagKnowledgeService
{
    protected ?array $knowledgeBaseCache = null;

    /**
     * Get path to the RAG knowledge base JSON file.
     */
    protected function getKnowledgeFilePath(): string
    {
        return storage_path('app/rag/resume_ats_knowledge_base.json');
    }

    /**
     * Load Knowledge Base vector/text chunks from JSON file or fallback memory.
     */
    protected function loadKnowledgeBase(): array
    {
        if ($this->knowledgeBaseCache !== null) {
            return $this->knowledgeBaseCache;
        }

        $filePath = $this->getKnowledgeFilePath();
        if (File::exists($filePath)) {
            $jsonContent = File::get($filePath);
            $decoded = json_decode($jsonContent, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $this->knowledgeBaseCache = $decoded;
                return $this->knowledgeBaseCache;
            }
        }

        // Fallback default structure
        $this->knowledgeBaseCache = [
            'java_fullstack' => [
                'tech' => 'Java Full-Stack Development',
                'keywords' => ['java', 'spring boot', 'microservices', 'hibernate', 'postgresql', 'react'],
                'docs' => 'Java Full-Stack ATS standards require Spring Boot 3, RESTful APIs, Microservices, Hibernate ORM, and React.',
                'action_verbs' => ['Architected', 'Engineered', 'Developed', 'Optimized'],
                'recommended_certifications' => ['Oracle Certified Professional: Java SE 17 Developer'],
                'recommended_soft_skills' => ['Problem Solving', 'System Architecture Thinking', 'Code Quality'],
                'project_templates' => ['E-Commerce Microservices Platform — Java Spring Boot, React, PostgreSQL'],
            ],
            'general_career' => [
                'tech' => 'Software Development & Technology',
                'keywords' => ['software', 'developer', 'coding', 'web', 'database', 'projects'],
                'docs' => 'General Technology ATS standards require clean professional summary, categorized technical skills, and bullet points with action verbs.',
                'action_verbs' => ['Developed', 'Built', 'Designed', 'Optimized'],
                'recommended_certifications' => ['Full-Stack Web Development Certification'],
                'recommended_soft_skills' => ['Problem Solving', 'Team Collaboration', 'Quick Learning'],
                'project_templates' => ['Full-Stack Web Application — Web Technologies, SQL'],
            ],
        ];

        return $this->knowledgeBaseCache;
    }

    /**
     * RAG Step 1 & 2: Retrieve Relevant Knowledge Context based on Query.
     */
    public function retrieveContext(string $query): array
    {
        $kb = $this->loadKnowledgeBase();
        $queryLower = strtolower($query);

        $bestMatchedKey = null;
        $highestMatchCount = 0;

        foreach ($kb as $key => $domain) {
            $count = 0;
            if (!empty($domain['keywords'])) {
                foreach ($domain['keywords'] as $keyword) {
                    if (str_contains($queryLower, strtolower($keyword))) {
                        $count++;
                    }
                }
            }
            if ($count > $highestMatchCount) {
                $highestMatchCount = $count;
                $bestMatchedKey = $key;
            }
        }

        $hasExactMatch = ($bestMatchedKey !== null && $highestMatchCount > 0);
        $matchedKey = $bestMatchedKey ?: 'general_career';
        $knowledge = $kb[$matchedKey] ?? $kb['general_career'];

        return [
            'matched_domain' => $matchedKey,
            'has_exact_rag_match' => $hasExactMatch,
            'tech_title' => $knowledge['tech'] ?? 'Software Technology',
            'retrieved_docs' => $knowledge['docs'] ?? '',
            'keywords' => $knowledge['keywords'] ?? [],
            'action_verbs' => $knowledge['action_verbs'] ?? ['Developed', 'Built', 'Designed'],
            'recommended_certifications' => $knowledge['recommended_certifications'] ?? [],
            'recommended_soft_skills' => $knowledge['recommended_soft_skills'] ?? ['Problem Solving', 'Teamwork', 'Communication'],
            'project_templates' => $knowledge['project_templates'] ?? [],
        ];
    }

    /**
     * SELF-LEARNING RAG: Dynamically appends newly LLM-learned domain knowledge
     * back into storage/app/rag/resume_ats_knowledge_base.json for instant future retrieval.
     */
    public function saveLearnedDomainKnowledge(string $domainTitle, array $knowledgeData): void
    {
        $kb = $this->loadKnowledgeBase();
        $domainKey = Str::slug($domainTitle, '_');

        if (empty($domainKey)) return;

        // Merge or update domain knowledge in repository
        $kb[$domainKey] = [
            'tech' => $domainTitle,
            'keywords' => array_values(array_unique(array_merge($knowledgeData['keywords'] ?? [], [strtolower($domainTitle)]))),
            'docs' => $knowledgeData['docs'] ?? "{$domainTitle} ATS standards and best practices.",
            'action_verbs' => $knowledgeData['action_verbs'] ?? ['Engineered', 'Developed', 'Optimized'],
            'recommended_certifications' => $knowledgeData['recommended_certifications'] ?? [],
            'recommended_soft_skills' => $knowledgeData['recommended_soft_skills'] ?? ['Problem Solving', 'Technical Competency'],
            'project_templates' => $knowledgeData['project_templates'] ?? [],
        ];

        $this->knowledgeBaseCache = $kb;

        // Persist to JSON file
        try {
            $filePath = $this->getKnowledgeFilePath();
            File::ensureDirectoryExists(dirname($filePath));
            File::put($filePath, json_encode($kb, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        } catch (\Throwable $e) {
            // Fail safe if file write is locked
        }
    }

    /**
     * RAG ATS Score calculation.
     */
    public function generateAugmentedAtsScore(string $skillsInput, string $jobDescription): array
    {
        $context = $this->retrieveContext($skillsInput . ' ' . $jobDescription);
        $jobLower = strtolower($jobDescription);

        $matched = [];
        $missing = [];

        foreach ($context['keywords'] as $kw) {
            if (str_contains($jobLower, strtolower($kw))) {
                $matched[] = strtoupper($kw);
            } else {
                $missing[] = strtoupper($kw);
            }
        }

        $score = min(98, max(65, 60 + (count($matched) * 5)));

        return [
            'domain' => $context['tech_title'],
            'retrieved_context' => $context['retrieved_docs'],
            'score' => $score,
            'matched_keywords' => $matched ?: [strtoupper($context['matched_domain'])],
            'missing_keywords' => array_slice($missing, 0, 4),
        ];
    }
}
