<?php

namespace App\Livewire\Student\Practice;

use App\Domain\Ai\Interview\Services\InterviewEvaluationService;
use App\Models\InterviewQuestion;
use App\Models\MockInterview;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.student')]
#[Title('Practice Weak Question - SkillBridge')]
class MockInterviewQuestionPractice extends Component
{
    public MockInterview $interview;
    public InterviewQuestion $question;
    public string $retakeTranscript = '';
    public ?array $retakeResult = null;
    public bool $isEvaluating = false;

    public function mount(string $id, string $questionId)
    {
        $this->interview = MockInterview::findOrFail($id);
        $this->question = InterviewQuestion::with('response.evaluation')->findOrFail($questionId);

        if ($this->interview->student_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function submitRetake(InterviewEvaluationService $evaluationService)
    {
        if (empty(trim($this->retakeTranscript))) {
            return;
        }

        $this->isEvaluating = true;

        $previousScore = 70;
        if ($this->question->response && $this->question->response->evaluation) {
            $eval = $this->question->response->evaluation;
            $previousScore = (int)round(($eval->technical_score + $eval->communication_score) / 2);
        }

        $this->retakeResult = $evaluationService->evaluateQuestionRetake(
            questionText: $this->question->question,
            candidateAnswer: $this->retakeTranscript,
            previousScore: $previousScore
        );

        $this->isEvaluating = false;
    }

    public function render()
    {
        return view('livewire.student.practice.mock-interview-question-practice');
    }
}
