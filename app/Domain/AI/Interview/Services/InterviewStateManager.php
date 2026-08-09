<?php

namespace App\Domain\Ai\Interview\Services;

use App\Models\MockInterview;

class InterviewStateManager
{
    /**
     * Generate initial state for a newly created MockInterview session.
     */
    public function createInitialState(MockInterview $interview): array
    {
        $role = $interview->role;
        $type = $interview->interview_type;
        $exp = $interview->technology ?? '0-1 Years';

        $topicsPool = $this->getTopicsPoolForRole($role, $type);

        return [
            'current_phase' => 'introduction', // introduction|fundamentals|practical|database|real_world|project|behavioral|closing
            'current_topic' => 'Introduction & Background',
            'difficulty_level' => $interview->difficulty ?? 3,
            'candidate_level_estimate' => $this->mapExpToLevel($exp),
            'topics_covered' => [],
            'topics_remaining' => $topicsPool,
            'strong_areas' => [],
            'weak_areas' => [],
            'questions_asked' => 0,
            'followups_used' => 0,
            'max_questions' => $interview->max_questions ?? 10,
            'technologies_mentioned' => [],
            'projects_mentioned' => [],
            'is_closing_phase' => false,
        ];
    }

    /**
     * Update interview state after candidate responds to a turn.
     */
    public function updateAfterAnswer(array $currentState, string $candidateTranscript, string $lastQuestionText): array
    {
        $state = $currentState;
        $state['questions_asked']++;

        $words = array_values(array_filter(explode(' ', trim(strtolower($candidateTranscript)))));
        $wordCount = count($words);

        // Detect "I don't know" or hesitation
        $isUnknown = preg_match('/\b(don\'t know|not sure|no idea|haven\'t used|forgot)\b/i', $candidateTranscript);

        // Update difficulty adaptively
        if ($isUnknown) {
            $state['difficulty_level'] = max(1, $state['difficulty_level'] - 1);
            if (!in_array($state['current_topic'], $state['weak_areas'])) {
                $state['weak_areas'][] = $state['current_topic'];
            }
        } elseif ($wordCount > 35) {
            $state['difficulty_level'] = min(5, $state['difficulty_level'] + 1);
            if (!in_array($state['current_topic'], $state['strong_areas'])) {
                $state['strong_areas'][] = $state['current_topic'];
            }
        }

        // Mark current topic as covered if not already
        if ($state['current_topic'] && !in_array($state['current_topic'], $state['topics_covered'])) {
            $state['topics_covered'][] = $state['current_topic'];
            $state['topics_remaining'] = array_values(array_diff($state['topics_remaining'], [$state['current_topic']]));
        }

        // Advance Phase based on question count
        $qCount = $state['questions_asked'];
        $maxQ = $state['max_questions'];

        if ($qCount >= $maxQ - 1) {
            $state['current_phase'] = 'closing';
            $state['is_closing_phase'] = true;
            $state['current_topic'] = 'Closing & Wrap-up';
        } else {
            $state['current_phase'] = match (true) {
                $qCount <= 1 => 'introduction',
                $qCount <= 3 => 'fundamentals',
                $qCount <= 5 => 'practical',
                $qCount <= 7 => 'database',
                $qCount <= 8 => 'real_world',
                $qCount <= 9 => 'behavioral',
                default => 'closing',
            };

            // Pick next topic from remaining
            if (!empty($state['topics_remaining'])) {
                $state['current_topic'] = $state['topics_remaining'][0];
            }
        }

        return $state;
    }

    /**
     * Map experience string to candidate level estimate.
     */
    protected function mapExpToLevel(string $exp): string
    {
        return match ($exp) {
            'Fresher' => 'fresher',
            '0-1 Years' => 'junior',
            '1-3 Years' => 'intermediate',
            '3-5 Years' => 'senior',
            '5+ Years' => 'lead/expert',
            default => 'intermediate',
        };
    }

    /**
     * Get predefined topic pool based on target role & interview type.
     */
    protected function getTopicsPoolForRole(string $role, string $type): array
    {
        $roleLower = strtolower($role);

        if (str_contains($roleLower, 'frontend') || str_contains($roleLower, 'react')) {
            return ['HTML & Semantic Web', 'CSS Flexbox & Grid', 'JavaScript Closures & Async', 'React Component State & Hooks', 'Performance & Component Re-renders', 'REST API Integration', 'Browser Storage & Security'];
        }

        if (str_contains($roleLower, 'laravel') || str_contains($roleLower, 'backend') || str_contains($roleLower, 'php')) {
            return ['Introduction', 'OOP Fundamentals & Interfaces', 'Laravel Eloquent & Relationships', 'RESTful API Architecture', 'Database Query Optimization & Indexing', 'Caching & Redis', 'Authentication & Middleware', 'Production Incident Debugging'];
        }

        if (str_contains($roleLower, 'python') || str_contains($roleLower, 'ai') || str_contains($roleLower, 'data')) {
            return ['Introduction', 'Python Data Structures & Generators', 'Data Preprocessing & NumPy/Pandas', 'Machine Learning Models & Evaluation', 'API Deployment & Docker', 'System Architecture & Trade-offs'];
        }

        if (str_contains($roleLower, 'devops')) {
            return ['Introduction', 'Linux Shell & Networking', 'Docker & Containerization', 'CI/CD Pipelines', 'Kubernetes Orchestration', 'Monitoring & Incident Response'];
        }

        return ['Introduction & Background', 'Programming Fundamentals', 'Architecture & Design Patterns', 'Databases & Query Optimization', 'Scalability & Trade-offs', 'Troubleshooting & Production Incidents', 'Behavioral & Teamwork'];
    }
}
