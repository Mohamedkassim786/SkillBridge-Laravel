<?php

namespace App\Livewire\Student\Practice;

use App\Domain\Ai\Interview\Services\InterviewEvaluationService;
use App\Models\MockInterview;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.student')]
#[Title('AI Mock Interview Coaching & Review Report - SkillBridge')]
class MockInterviewReport extends Component
{
    public MockInterview $interview;
    public array $evaluationData = [];

    public function mount(string $id, InterviewEvaluationService $evaluationService)
    {
        $this->interview = MockInterview::with(['questions.response.evaluation', 'report', 'student'])->findOrFail($id);

        if ($this->interview->student_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this interview report.');
        }

        $this->evaluationData = $evaluationService->evaluateFullInterview($this->interview);
    }

    public function render()
    {
        return view('livewire.student.practice.mock-interview-report', [
            'report' => $this->interview->report,
            'questions' => $this->interview->questions,
        ]);
    }
}
