<?php

namespace App\Domain\Ai\Interview\Providers;

use App\Domain\Ai\Interview\Contracts\VoiceInterviewProviderInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class NvidiaNemotronVoiceChatProvider implements VoiceInterviewProviderInterface
{
    protected string $apiKey;
    protected string $model;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('ai.nvidia.nemotron_api_key') ?: config('ai.nvidia.api_key');
        $this->model = config('ai.nvidia.model', 'meta/llama-3.1-8b-instruct');
        $this->baseUrl = config('ai.nvidia.base_url', 'https://integrate.api.nvidia.com/v1');
    }

    /**
     * Generate the next conversational turn from Sarah (AI Technical Recruiter persona).
     */
    public function generateInterviewerTurn(array $conversationHistory, array $interviewContext): array
    {
        $candidateName = $interviewContext['candidate_name'] ?? 'Candidate';
        $role = $interviewContext['role'] ?? 'Software Developer';
        $type = $interviewContext['interview_type'] ?? 'technical';
        $exp = $interviewContext['experience_level'] ?? '0-1 Years';
        $difficulty = $interviewContext['difficulty'] ?? 'intermediate';
        $resumeCtx = $interviewContext['resume_context'] ?? 'No resume provided.';
        $jobCtx = $interviewContext['job_context'] ?? 'No job posting provided.';

        $stateJson = json_encode($interviewContext['state'] ?? [], JSON_PRETTY_PRINT);

        $systemPrompt = <<<PROMPT
You are Sarah, a Senior Technical Recruiter and Engineering Hiring Manager conducting a live voice mock interview.

CANDIDATE INFO:
Name: {$candidateName}
Target Role: {$role}
Experience Level: {$exp}
Interview Focus: {$type}

CURRENT INTERVIEW STATE:
{$stateJson}

SARAH'S PERSONA & CONVERSATIONAL RULES:
1. **ROLE & TONE**: You are Sarah — professional, calm, friendly, confident, and conversational. Sound like a real senior technical interviewer on a live video/phone call.
2. **SPEAKING STYLE**: Speak in natural, spoken conversational English. Use natural transitions like "That's a good start", "Okay, interesting", "Let's take that one step further", "Why did you choose that approach?".
3. **STRICT CONCISENESS**: Keep responses under 1 to 3 short spoken sentences. Never give long lectures or tutorials.
4. **ONE QUESTION AT A TIME**: Ask ONLY ONE question per turn.
5. **FOLLOW-UP DECISION ENGINE**:
   - If candidate answer is strong/complete: Acknowledge briefly and probe deeper or increase difficulty slightly.
   - If candidate answer is shallow: Ask for a specific practical/code example.
   - If candidate is partially correct: Gently guide them ("You're close, but what about...").
   - If candidate says "I don't know": Respond empathetically ("No problem, let's look at a simpler angle") and ask a foundational question.
   - If candidate asks to repeat or clarify: Repeat or clarify naturally without changing the topic.
6. **NO MARKDOWN & NO LISTS**: Do NOT use bullet points, bold markers (**), numbered lists, code blocks, or special characters. Plain spoken sentences ONLY for speech synthesis.
7. **NO META-COMMENTARY**: Never say "Thank you for your response", "Question 3", "Your response has been recorded", or "I don't see a resume".

Candidate Resume Context:
{$resumeCtx}

Job Context:
{$jobCtx}
PROMPT;

        $messages = [
            ['role' => 'system', 'content' => $systemPrompt],
        ];

        foreach ($conversationHistory as $turn) {
            $roleName = ($turn['speaker'] ?? '') === 'candidate' ? 'user' : 'assistant';
            $messages[] = [
                'role' => $roleName,
                'content' => $turn['transcript'] ?? '',
            ];
        }

        try {
            $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => 'Bearer ' . trim($this->apiKey),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->timeout(12)->post("{$this->baseUrl}/chat/completions", [
                'model' => $this->model,
                'messages' => $messages,
                'temperature' => 0.4,
                'max_tokens' => 200,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['choices'][0]['message']['content'] ?? null;
                if (!empty($reply)) {
                    $cleanText = html_entity_decode(trim($reply), ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    $cleanText = preg_replace('/[*_#`~]/', '', $cleanText);
                    return [
                        'text' => trim($cleanText),
                        'audio' => null,
                        'is_fallback' => false,
                    ];
                }
            }
        } catch (\Throwable $e) {
        }

        // Conversational Fallback turns for Sarah
        $turnCount = count($conversationHistory);
        $fallbackText = match ($turnCount) {
            0 => "Hello {$candidateName}! I'm Sarah, Senior Technical Recruiter. Thanks for joining today's {$role} interview. To get started, could you walk me through your technical background and why you're interested in this role?",
            1, 2 => "That's very interesting. Could you explain the core architecture of the strongest project you've built in {$role} and your specific contributions?",
            3, 4 => "Great. When building production software, how do you handle unexpected runtime errors, performance bottlenecks, or high latency?",
            5, 6 => "Thank you for sharing that. Describe a scenario where you had to collaborate with a team under a tight deadline to solve a complex issue.",
            default => "Thank you so much for walking through these technical topics with me today! Do you have any questions for me before we wrap up our interview?",
        };

        return [
            'text' => $fallbackText,
            'audio' => null,
            'is_fallback' => true,
        ];
    }

    /**
     * Synthesize text to speech stream or base64 audio chunk for Sarah's voice response.
     */
    public function synthesizeSpeech(string $text): ?string
    {
        return null;
    }

    /**
     * Transcribe candidate audio chunk to text transcript.
     */
    public function transcribeSpeech(string $audioBase64): ?string
    {
        return null;
    }
}
