<?php

namespace App\Domain\Ai\CoverLetter;

class CoverLetterContentNormalizer
{
    /**
     * Skill name mapping for canonical technology titles.
     */
    protected array $skillNormalizationMap = [
        'reactjs' => 'React.js',
        'react.js' => 'React.js',
        'react' => 'React.js',
        'nodejs' => 'Node.js',
        'node.js' => 'Node.js',
        'node' => 'Node.js',
        'expressjs' => 'Express.js',
        'express.js' => 'Express.js',
        'express' => 'Express.js',
        'mongodb' => 'MongoDB',
        'mongo' => 'MongoDB',
        'postgresql' => 'PostgreSQL',
        'postgres' => 'PostgreSQL',
        'mysql' => 'MySQL',
        'sql' => 'SQL',
        'sqlite' => 'SQLite',
        'python' => 'Python',
        'javascript' => 'JavaScript',
        'js' => 'JavaScript',
        'typescript' => 'TypeScript',
        'ts' => 'TypeScript',
        'java' => 'Java',
        'c++' => 'C++',
        'php' => 'PHP',
        'laravel' => 'Laravel',
        'django' => 'Django',
        'spring boot' => 'Spring Boot',
        'springboot' => 'Spring Boot',
        'docker' => 'Docker',
        'aws' => 'AWS',
        'git' => 'Git',
        'github' => 'GitHub',
        'gitlab' => 'GitLab',
        'html5' => 'HTML5',
        'html' => 'HTML5',
        'css3' => 'CSS3',
        'css' => 'CSS3',
        'tailwind' => 'Tailwind CSS',
        'tailwindcss' => 'Tailwind CSS',
        'tailwind css' => 'Tailwind CSS',
        'bootstrap' => 'Bootstrap',
        'nextjs' => 'Next.js',
        'next.js' => 'Next.js',
        'vue' => 'Vue.js',
        'vuejs' => 'Vue.js',
        'angular' => 'Angular',
        'rest api' => 'REST APIs',
        'rest apis' => 'REST APIs',
        'jwt' => 'JWT',
        'graphql' => 'GraphQL',
        'prisma' => 'Prisma',
        'redux' => 'Redux',
    ];

    /**
     * Role title mapping for canonical job roles.
     */
    protected array $roleNormalizationMap = [
        'full stack' => 'Full Stack Developer',
        'full stack developer' => 'Full Stack Developer',
        'fullstack' => 'Full Stack Developer',
        'fullstack developer' => 'Full Stack Developer',
        'backend' => 'Backend Developer',
        'backend developer' => 'Backend Developer',
        'frontend' => 'Frontend Developer',
        'frontend developer' => 'Frontend Developer',
        'software engineer' => 'Software Engineer',
        'software developer' => 'Software Developer',
        'web developer' => 'Web Developer',
        'data analyst' => 'Data Analyst',
        'data engineer' => 'Data Engineer',
        'machine learning engineer' => 'Machine Learning Engineer',
        'ai engineer' => 'AI Engineer',
        'devops engineer' => 'DevOps Engineer',
        'qa engineer' => 'QA Engineer',
    ];

    /**
     * Normalize raw job title to canonical Title Case.
     */
    public function normalizeTargetRole(string $role): string
    {
        $trimRole = trim($role);
        if (empty($trimRole)) return 'Software Developer';

        $lower = strtolower($trimRole);
        return $this->roleNormalizationMap[$lower] ?? ucwords($lower);
    }

    /**
     * Normalize company name.
     */
    public function normalizeCompanyName(string $company): string
    {
        $trimCompany = trim($company);
        if (empty($trimCompany)) return 'Target Company';

        return ucwords(strtolower($trimCompany));
    }

    /**
     * Normalize skills list into array of canonical skill titles.
     */
    public function parseNormalizedSkills(string $skillsInput): array
    {
        if (empty(trim($skillsInput))) return [];

        $items = array_filter(array_map('trim', preg_split('/[,\n]+/', $skillsInput)));
        $clean = [];

        foreach ($items as $item) {
            $lower = strtolower($item);
            $norm = $this->skillNormalizationMap[$lower] ?? ucwords($lower);
            if (!in_array($norm, $clean)) {
                $clean[] = $norm;
            }
        }

        return $clean;
    }

    /**
     * Format array of skills into natural english sentence phrasing.
     * e.g. ["React.js", "Node.js", "Python", "MongoDB"] -> "React.js, Node.js, Python, and MongoDB"
     */
    public function formatSkillsAsNaturalSentence(array $skills): string
    {
        if (empty($skills)) return 'modern software development tools';

        $count = count($skills);
        if ($count === 1) return $skills[0];
        if ($count === 2) return $skills[0] . ' and ' . $skills[1];

        $last = array_pop($skills);
        return implode(', ', $skills) . ', and ' . $last;
    }

    /**
     * Sanitize generated text to eliminate raw skill dumps, unsupported claims, and exaggerated AI language.
     */
    public function sanitizeText(string $text, array $userInput = []): string
    {
        if (empty(trim($text))) return '';

        // 1. Replace raw comma-joined skills if they appear verbatim
        $rawSkills = trim($userInput['skillsInput'] ?? '');
        if (!empty($rawSkills) && str_contains($rawSkills, ',')) {
            $normSkills = $this->parseNormalizedSkills($rawSkills);
            $naturalSkills = $this->formatSkillsAsNaturalSentence($normSkills);

            $text = str_replace($rawSkills, $naturalSkills, $text);
            $text = str_replace(strtolower($rawSkills), $naturalSkills, $text);
        }

        // 2. Replace exaggerated / unsupported claims
        $replacements = [
            '/\bproven expertise in\b/i' => 'practical experience with',
            '/\bextensive professional experience\b/i' => 'hands-on project experience',
            '/\bproduction-scale experience\b/i' => 'practical application experience',
            '/\b5 years of production experience\b/i' => 'hands-on project experience',
            '/\bmeasurable results\b/i' => 'practical software solutions',
            '/\bI am thrilled to express\b/i' => 'I am writing to express',
            '/\bI am incredibly excited\b/i' => 'I am writing to express my interest in',
            '/\bI am uniquely positioned\b/i' => 'I am confident in my ability',
            '/\bI am the perfect candidate\b/i' => 'I am eager to contribute',
            '/\ba wealth of experience\b/i' => 'hands-on project experience',
        ];

        $text = preg_replace(array_keys($replacements), array_values($replacements), $text);

        return trim($text);
    }

    /**
     * Construct truthful, grounded structured fallback data if AI call fails.
     */
    public function buildStructuredFallback(array $userInput): array
    {
        $role = $this->normalizeTargetRole($userInput['targetRole'] ?? '');
        $company = $this->normalizeCompanyName($userInput['companyName'] ?? '');
        $name = trim($userInput['fullName'] ?? 'Candidate');
        $location = trim($userInput['location'] ?? '');
        $hiringManager = trim($userInput['hiringManager'] ?? '') ?: 'Hiring Manager';

        $skills = $this->parseNormalizedSkills($userInput['skillsInput'] ?? '');
        $naturalSkills = $this->formatSkillsAsNaturalSentence($skills);

        $projects = trim($userInput['coreHighlights'] ?? '');

        // Paragraph 1 - Introduction
        $opening = "I am writing to express my interest in the {$role} position at {$company}. As a developer with hands-on experience in web application development, I am eager to apply my technical background and problem-solving skills to your engineering team.";

        // Paragraph 2 - Relevant Experience
        if (!empty($projects)) {
            $firstSentence = strtok($projects, "\n.");
            $experienceParagraph = "Through my practical project work, I have gained hands-on exposure to building software applications using {$naturalSkills}. Specifically, I have worked on {$firstSentence}, which strengthened my understanding of software development, API design, and database integration.";
        } else {
            $experienceParagraph = "Through my academic and project experience, I have developed applications using {$naturalSkills}. My background has given me practical exposure to building responsive interfaces, developing APIs, and working with database systems.";
        }

        // Paragraph 3 - Value / Fit
        $fitParagraph = "I enjoy solving practical programming challenges and working across software components. I am particularly interested in the opportunity at {$company} where I can continue strengthening my software engineering capabilities while contributing to collaborative development efforts.";

        // Paragraph 4 - Closing
        $closingParagraph = "Thank you for considering my application. I would welcome the opportunity to discuss how my background and skills align with the {$role} position.";

        // Core Qualifications Bullets (Grounding only in available facts)
        $qualifications = [];
        if (!empty($skills)) {
            $topSkills = array_slice($skills, 0, 3);
            $qualifications[] = "Practical experience developing applications with " . implode(', ', $topSkills);
        } else {
            $qualifications[] = "Hands-on experience in software development and web applications";
        }

        $qualifications[] = "Experience with API development and database integration";
        
        if (!empty($projects)) {
            $qualifications[] = "Project experience: " . substr(strtok($projects, "\n"), 0, 60);
        } else {
            $qualifications[] = "Strong foundation in clean code structure and problem solving";
        }

        $qualifications[] = "Eager to contribute technical skills and learn in a collaborative environment";

        return [
            'target_role' => $role,
            'company' => $company,
            'hiring_manager' => $hiringManager,
            'greeting' => "Dear {$hiringManager},",
            'opening' => $opening,
            'experience_paragraph' => $experienceParagraph,
            'fit_paragraph' => $fitParagraph,
            'closing_paragraph' => $closingParagraph,
            'core_qualifications' => array_slice($qualifications, 0, 4),
            'signature' => $name,
            'full_letter_body' => "Dear {$hiringManager},\n\n{$opening}\n\n{$experienceParagraph}\n\n{$fitParagraph}\n\n{$closingParagraph}\n\nSincerely,\n{$name}",
        ];
    }
}
