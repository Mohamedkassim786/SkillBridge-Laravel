<?php

namespace App\Domain\AI\Services;

use App\Models\AiModel;
use App\Models\AiTokenUsage;

class LLMProviderFactory
{
    /**
     * Audit token usage and calculate USD cost for every LLM interaction.
     */
    public function recordTokenUsage(string $userId, string $modelCode, string $featureContext, int $inputTokens, int $outputTokens): AiTokenUsage
    {
        $model = AiModel::where('model_code', $modelCode)->first();

        $costInput = ($inputTokens / 1000) * ($model->cost_per_1k_input_tokens ?? 0.0015);
        $costOutput = ($outputTokens / 1000) * ($model->cost_per_1k_output_tokens ?? 0.002);
        $totalCost = $costInput + $costOutput;

        return AiTokenUsage::create([
            'user_id' => $userId,
            'model_id' => $model ? $model->id : null,
            'feature_context' => $featureContext,
            'input_tokens' => $inputTokens,
            'output_tokens' => $outputTokens,
            'calculated_cost_usd' => $totalCost,
        ]);
    }
}
