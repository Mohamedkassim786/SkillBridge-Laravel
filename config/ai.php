<?php

return [
    'default_provider' => env('AI_DEFAULT_PROVIDER', 'nvidia'),

    'models' => [
        'interview_generation' => env('NVIDIA_LLM_MODEL', 'meta/llama-3.3-70b-instruct'),
        'interview_evaluation' => env('NVIDIA_LLM_EVAL_MODEL', 'meta/llama-3.3-70b-instruct'),
        'coding_analysis'       => env('NVIDIA_LLM_CODING_MODEL', 'deepseek-ai/deepseek-r1'),
        'skill_assessment'      => env('NVIDIA_LLM_SKILL_MODEL', 'meta/llama-3.3-70b-instruct'),
        'nemotron_voicechat'    => env('NVIDIA_NEMOTRON_MODEL', 'nvidia/nemotron-voicechat'),
        'deepseek_coding'       => env('DEEPSEEK_CODING_MODEL', 'deepseek-ai/deepseek-r1'),
    ],

    'nvidia' => [
        'api_key' => env('NVIDIA_API_KEY'),
        'model' => env('NVIDIA_MODEL', 'meta/llama-3.1-8b-instruct'),
        'base_url' => 'https://integrate.api.nvidia.com/v1',
        'asr_model' => env('NVIDIA_ASR_MODEL', 'nvidia/parakeet-ctc-1.1b'),
        'tts_model' => env('NVIDIA_TTS_MODEL', 'nvidia/magpie-tts'),
        'tts_voice' => env('NVIDIA_TTS_VOICE', 'Magpie-Multilingual.EN-US.Aria'),
        'nemotron_api_key' => env('NVIDIA_NEMOTRON_API_KEY', env('NVIDIA_API_KEY')),
        'nemotron_model'   => env('NVIDIA_NEMOTRON_MODEL', 'nvidia/nemotron-voicechat'),
    ],

    'gemini' => [
        'api_key' => env('GEMINI_API_KEY', null),
        'model' => env('GEMINI_MODEL', 'gemini-1.5-flash'),
    ],

    'openai' => [
        'api_key' => env('OPENAI_API_KEY', null),
        'model' => env('OPENAI_MODEL', 'gpt-4o'),
    ],
];
