<?php

namespace App\Services;

class PromiseGenerator
{
    public function __construct(
        private PromptBuilder $promptBuilder,
        private GeminiService $geminiService
    ) {}

    public function generatePromise(array $answers): string
    {
        $prompt = $this->promptBuilder->build($answers);
        return $this->geminiService->generate($prompt);
    }
}
