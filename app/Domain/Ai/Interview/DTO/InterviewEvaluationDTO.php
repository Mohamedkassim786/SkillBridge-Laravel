<?php

namespace App\Domain\Ai\Interview\DTO;

class InterviewEvaluationDTO
{
    public function __construct(
        public int $overallScore,
        public int $technicalScore,
        public int $communicationScore,
        public int $clarityScore,
        public int $confidenceScore,
        public int $relevanceScore,
        public int $structureScore,
        public int $grammarScore,
        public int $professionalismScore,
        public array $strengths,
        public array $weaknesses,
        public array $improvementPlan,
        public array $recommendedTopics,
        public string $finalFeedback
    ) {}

    public function toArray(): array
    {
        return [
            'overall_score' => $this->overallScore,
            'technical_score' => $this->technicalScore,
            'communication_score' => $this->communicationScore,
            'clarity_score' => $this->clarityScore,
            'confidence_score' => $this->confidenceScore,
            'relevance_score' => $this->relevanceScore,
            'structure_score' => $this->structureScore,
            'grammar_score' => $this->grammarScore,
            'professionalism_score' => $this->professionalismScore,
            'strengths' => $this->strengths,
            'weaknesses' => $this->weaknesses,
            'improvement_plan' => $this->improvementPlan,
            'recommended_topics' => $this->recommendedTopics,
            'final_feedback' => $this->finalFeedback,
        ];
    }
}
