<?php

namespace App\Domain\Ai\Interview\DTO;

class ConversationTurnDTO
{
    public function __construct(
        public string $speaker, // 'interviewer' (Sarah) or 'candidate'
        public string $transcript,
        public int $sequence,
        public ?string $audioPath = null,
        public bool $isInterrupted = false,
        public ?int $durationSeconds = null
    ) {}

    public function toArray(): array
    {
        return [
            'speaker' => $this->speaker,
            'transcript' => $this->transcript,
            'sequence' => $this->sequence,
            'audio_path' => $this->audioPath,
            'is_interrupted' => $this->isInterrupted,
            'duration_seconds' => $this->durationSeconds,
        ];
    }
}
