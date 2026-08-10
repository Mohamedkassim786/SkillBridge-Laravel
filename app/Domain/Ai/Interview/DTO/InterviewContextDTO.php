<?php

namespace App\Domain\Ai\Interview\DTO;

class InterviewContextDTO
{
    public function __construct(
        public string $candidateName,
        public string $role,
        public string $interviewType,
        public string $experienceLevel,
        public string $difficulty,
        public string $resumeContext = '',
        public string $jobContext = '',
        public array $skills = []
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            candidateName: $data['candidate_name'] ?? 'Candidate',
            role: $data['role'] ?? 'Software Developer',
            interviewType: $data['interview_type'] ?? 'technical',
            experienceLevel: $data['experience_level'] ?? '0-1 Years',
            difficulty: $data['difficulty'] ?? 'intermediate',
            resumeContext: $data['resume_context'] ?? '',
            jobContext: $data['job_context'] ?? '',
            skills: $data['skills'] ?? []
        );
    }

    public function toArray(): array
    {
        return [
            'candidate_name' => $this->candidateName,
            'role' => $this->role,
            'interview_type' => $this->interviewType,
            'experience_level' => $this->experienceLevel,
            'difficulty' => $this->difficulty,
            'resume_context' => $this->resumeContext,
            'job_context' => $this->jobContext,
            'skills' => $this->skills,
        ];
    }
}
