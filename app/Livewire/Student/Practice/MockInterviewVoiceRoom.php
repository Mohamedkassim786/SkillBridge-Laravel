<?php

namespace App\Livewire\Student\Practice;

use App\Domain\Ai\Interview\Services\VoiceInterviewSessionService;
use App\Models\MockInterview;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.student')]
#[Title('AI Voice Interview Room - SkillBridge')]
class MockInterviewVoiceRoom extends Component
{
    public MockInterview $interview;
    public string $currentQuestionText = '';
    public int $currentSequence = 1;
    public bool $isMuted = false;
    public bool $showTranscript = false;

    public function mount(string $id)
    {
        $this->interview = MockInterview::with('questions')->findOrFail($id);

        if ($this->interview->student_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this interview session.');
        }

        $latestQuestion = $this->interview->questions()->orderBy('sequence', 'desc')->first();
        if ($latestQuestion) {
            $this->currentQuestionText = $latestQuestion->question;
            $this->currentSequence = $latestQuestion->sequence;
        }
    }

    public function submitCandidateTurn(string $transcript, bool $isInterrupted = false, int $durationSeconds = 15, VoiceInterviewSessionService $sessionService)
    {
        if (empty(trim($transcript))) {
            return;
        }

        $result = $sessionService->processCandidateTurn(
            interview: $this->interview,
            candidateTranscript: $transcript,
            isInterrupted: $isInterrupted,
            durationSeconds: $durationSeconds
        );

        $this->currentQuestionText = $result['interviewer_text'];
        $this->currentSequence = $result['sequence'];

        $this->dispatch('ai-spoken', text: $result['interviewer_text']);

        if ($result['is_ending'] ?? false) {
            $this->dispatch('interview-ending');
        }
    }

    public function toggleMute()
    {
        $this->isMuted = !$this->isMuted;
    }

    public function toggleTranscript()
    {
        $this->showTranscript = !$this->showTranscript;
    }

    public function finishInterview(VoiceInterviewSessionService $sessionService)
    {
        $sessionService->endInterview($this->interview);
        return redirect()->route('student.practice.mock.report', ['id' => $this->interview->id]);
    }

    public function render()
    {
        $conversation = $this->interview->questions()->with('response')->orderBy('sequence', 'asc')->get();

        return view('livewire.student.practice.mock-interview-voice-room', [
            'conversation' => $conversation,
        ]);
    }
}
