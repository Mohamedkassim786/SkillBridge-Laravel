<?php

namespace App\Domain\Ai\Interview\Services;

use App\Domain\Ai\Interview\Contracts\VoiceInterviewProviderInterface;
use App\Models\InterviewQuestion;
use App\Models\InterviewResponse;
use App\Models\MockInterview;

class VoiceInterviewSessionService
{
    protected VoiceInterviewProviderInterface $voiceProvider;
    protected InterviewStateManager $stateManager;

    public function __construct(VoiceInterviewProviderInterface $voiceProvider, InterviewStateManager $stateManager)
    {
        $this->voiceProvider = $voiceProvider;
        $this->stateManager = $stateManager;
    }

    /**
     * Start a new real-time AI Voice Mock Interview session.
     */
    public function createSession(
        string $userId,
        string $role,
        string $interviewType = 'technical',
        string $experienceLevel = '0-1 Years',
        int $difficulty = 3,
        ?string $resumeId = null,
        ?string $jobId = null
    ): MockInterview {
        $interview = MockInterview::create([
            'student_id' => $userId,
            'role' => $role,
            'interview_type' => $interviewType,
            'technology' => $experienceLevel,
            'difficulty' => $difficulty,
            'max_questions' => 10,
            'mode' => 'voice',
            'voice' => 'Sarah (Senior Technical Recruiter)',
            'resume_id' => $resumeId,
            'job_id' => $jobId,
            'status' => 'IN_PROGRESS',
            'started_at' => now(),
        ]);

        // Initialize state engine
        $initialState = $this->stateManager->createInitialState($interview);
        $interview->update(['interview_state' => $initialState]);

        // Generate Sarah's initial greeting turn
        $context = $this->buildContextArray($interview);
        $greeting = $this->voiceProvider->generateInterviewerTurn([], $context);

        // Store first question turn
        InterviewQuestion::create([
            'mock_interview_id' => $interview->id,
            'question' => $greeting['text'],
            'question_type' => $interviewType,
            'topic' => $role,
            'difficulty' => $difficulty,
            'sequence' => 1,
            'asked_at' => now(),
        ]);

        return $interview;
    }

    /**
     * Process candidate speech turn and generate Sarah's next conversational response.
     */
    public function processCandidateTurn(MockInterview $interview, string $candidateTranscript, bool $isInterrupted = false, ?int $durationSeconds = null): array
    {
        $latestQuestion = $interview->questions()->orderBy('sequence', 'desc')->first();

        // 1. Save candidate response if question exists
        if ($latestQuestion && !$latestQuestion->response) {
            $words = array_values(array_filter(explode(' ', trim($candidateTranscript))));
            $wordCount = count($words);
            $wpm = ($durationSeconds && $durationSeconds > 0) ? (int)round(($wordCount / $durationSeconds) * 60) : 135;

            InterviewResponse::create([
                'interview_question_id' => $latestQuestion->id,
                'transcript' => $candidateTranscript,
                'duration' => $durationSeconds ?: 20,
                'word_count' => $wordCount,
                'words_per_minute' => $wpm,
                'pause_count' => $isInterrupted ? 1 : 0,
                'filler_word_count' => substr_count(strtolower($candidateTranscript), 'um') + substr_count(strtolower($candidateTranscript), 'uh') + substr_count(strtolower($candidateTranscript), 'like'),
            ]);
        }

        // 2. Update Interview State
        $currentState = $interview->interview_state ?? $this->stateManager->createInitialState($interview);
        $updatedState = $this->stateManager->updateAfterAnswer($currentState, $candidateTranscript, $latestQuestion ? $latestQuestion->question : '');
        $interview->update(['interview_state' => $updatedState]);

        // 3. Fetch full conversation history
        $history = $this->getConversationHistory($interview);

        // 4. Generate Sarah's next response turn
        $context = $this->buildContextArray($interview);
        $nextTurn = $this->voiceProvider->generateInterviewerTurn($history, $context);

        // 5. Store next question turn
        $nextSequence = ($latestQuestion ? $latestQuestion->sequence : 0) + 1;
        $newQuestion = InterviewQuestion::create([
            'mock_interview_id' => $interview->id,
            'question' => $nextTurn['text'],
            'question_type' => $interview->interview_type,
            'topic' => $updatedState['current_topic'] ?? $interview->role,
            'difficulty' => $updatedState['difficulty_level'] ?? $interview->difficulty,
            'sequence' => $nextSequence,
            'asked_at' => now(),
        ]);

        return [
            'question_id' => $newQuestion->id,
            'sequence' => $nextSequence,
            'interviewer_text' => $nextTurn['text'],
            'audio' => $nextTurn['audio'] ?? null,
            'is_ending' => $updatedState['is_closing_phase'] ?? false,
        ];
    }

    /**
     * Build full sequential conversation history array.
     */
    public function getConversationHistory(MockInterview $interview): array
    {
        $questions = $interview->questions()->with('response')->orderBy('sequence', 'asc')->get();
        $turns = [];

        foreach ($questions as $q) {
            $turns[] = [
                'speaker' => 'interviewer',
                'transcript' => $q->question,
                'sequence' => $q->sequence,
            ];

            if ($q->response) {
                $turns[] = [
                    'speaker' => 'candidate',
                    'transcript' => $q->response->transcript,
                    'sequence' => $q->sequence,
                ];
            }
        }

        return $turns;
    }

    /**
     * Mark interview as COMPLETED.
     */
    public function endInterview(MockInterview $interview): void
    {
        $started = $interview->started_at ?: now();
        $durationSeconds = now()->diffInSeconds($started);

        $interview->update([
            'status' => 'COMPLETED',
            'completed_at' => now(),
            'duration' => $durationSeconds,
        ]);
    }

    /**
     * Build context array for AI provider.
     */
    protected function buildContextArray(MockInterview $interview): array
    {
        $student = $interview->student;
        $resume = $interview->resume ?: \App\Models\UserResume::where('user_id', $interview->student_id)->latest()->first();
        $job = $interview->job;

        if ($resume) {
            $resumeTitle = $resume->title ?: 'Resume';
            $skillsStr = is_array($resume->parsed_skills) ? implode(', ', $resume->parsed_skills) : ($resume->parsed_skills ?? 'General Technical Skills');
            $summaryText = substr($resume->parsed_text ?? '', 0, 300);
            $resumeCtx = "Resume Title: {$resumeTitle}\nKey Skills: {$skillsStr}\nSummary: {$summaryText}";
        } else {
            $resumeCtx = "Target candidate applying for {$interview->role} position as a {$interview->technology} candidate.";
        }

        $jobCtx = $job ? "Job Title: {$job->title}\nCompany: {$job->company_name}\nDescription: {$job->description}" : 'General job practice.';

        return [
            'candidate_name' => $student->name ?? 'Candidate',
            'role' => $interview->role,
            'interview_type' => $interview->interview_type,
            'experience_level' => $interview->technology ?? '0-1 Years',
            'difficulty' => $interview->difficulty ?? 3,
            'resume_context' => $resumeCtx,
            'job_context' => $jobCtx,
            'state' => $interview->interview_state ?? [],
        ];
    }
}
