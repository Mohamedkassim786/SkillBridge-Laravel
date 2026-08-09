<?php

namespace App\Domain\Ai\Interview\Contracts;

use App\Models\MockInterview;

interface InterviewEvaluationServiceInterface
{
    /**
     * Perform detailed post-interview evaluation across 8 rubrics, STAR frameworks, and 7-day plan.
     */
    public function evaluateFullInterview(MockInterview $interview): array;

    /**
     * Evaluate a single question retake answer and compare previous vs new score.
     */
    public function evaluateQuestionRetake(string $questionText, string $candidateAnswer, int $previousScore): array;
}
