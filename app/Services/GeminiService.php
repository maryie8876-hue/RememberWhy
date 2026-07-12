<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class GeminiService
{
    public function generate(string $prompt): string
    {
        $apiKey = env('GEMINI_API_KEY');
        if (empty($apiKey)) {
            throw new Exception("Gemini API Key is missing");
        }

        $model = config('rememberwhy.gemini_model', 'gemini-1.5-flash');
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

        $response = Http::timeout(30)->post($url, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
            ]
        ]);

        if ($response->failed()) {
            throw new Exception("Gemini API request failed: " . $response->body());
        }

        $data = $response->json();
        
        $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

        if (!$text) {
            throw new Exception("Unexpected Gemini API response format");
        }

        return $text;
    }
}
