<?php

namespace App\Domain\Ai\Interview\Contracts;

interface VoiceInterviewProviderInterface
{
    /**
     * Generate the next conversational turn from Sarah (AI Technical Recruiter persona).
     */
    public function generateInterviewerTurn(array $conversationHistory, array $interviewContext): array;

    /**
     * Synthesize text to speech stream or base64 audio chunk for Sarah's voice response.
     */
    public function synthesizeSpeech(string $text): ?string;

    /**
     * Transcribe candidate audio chunk to text transcript.
     */
    public function transcribeSpeech(string $audioBase64): ?string;
}
