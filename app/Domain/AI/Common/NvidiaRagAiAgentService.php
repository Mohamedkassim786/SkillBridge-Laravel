<?php

namespace App\Domain\Ai\Common;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class NvidiaRagAiAgentService
{
    protected RagKnowledgeService $ragKnowledgeService;
    protected LLMProviderFactory $tokenFactory;

    public function __construct(RagKnowledgeService $ragKnowledgeService, LLMProviderFactory $tokenFactory)
    {
        $this->ragKnowledgeService = $ragKnowledgeService;
        $this->tokenFactory = $tokenFactory;
    }

    /**
     * Send HTTP Chat Completion POST request to NVIDIA Nim API.
     * Supports configurable max_tokens and timeout per feature.
     */
    public function callNvidiaNim(array $messages, float $temperature = 0.2, int $maxTokens = 2048, int $timeout = 12, ?string $model = null): ?array
    {
        $apiKey = config('ai.nvidia.api_key');
        $model = $model ?? config('ai.nvidia.model', 'meta/llama-3.1-8b-instruct');
        $baseUrl = config('ai.nvidia.base_url', 'https://integrate.api.nvidia.com/v1');

        if (empty($apiKey)) {
            return null;
        }

        try {
            $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => 'Bearer ' . trim($apiKey),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->timeout($timeout)->post("{$baseUrl}/chat/completions", [
                'model' => $model,
                'messages' => $messages,
                'temperature' => $temperature,
                'max_tokens' => $maxTokens,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Audit token usage
                $usage = $data['usage'] ?? [];
                if (auth()->check()) {
                    $this->tokenFactory->recordTokenUsage(
                        userId: auth()->id(),
                        modelCode: $model,
                        featureContext: 'nvidia_rag_agent',
                        inputTokens: $usage['prompt_tokens'] ?? 150,
                        outputTokens: $usage['completion_tokens'] ?? 250
                    );
                }

                $content = $data['choices'][0]['message']['content'] ?? null;
                if ($content) {
                    return $this->parseJsonOrCleanString($content);
                }
            }
        } catch (\Throwable $e) {
            // Failover gracefully to local RAG fallback
        }

        return null;
    }

    /**
     * Safely parse LLM JSON responses or sanitize text string.
     */
    protected function parseJsonOrCleanString(string $content): array
    {
        $content = trim($content);
        if (str_contains($content, '```json')) {
            $content = Str::between($content, '```json', '```');
        } elseif (str_contains($content, '```')) {
            $content = Str::between($content, '```', '```');
        }

        $decoded = json_decode(trim($content), true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        return ['raw_response' => $content];
    }
}
