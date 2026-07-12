<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class PromptBuilder
{
    public function build(array $answers): string
    {
        $templatePath = resource_path('prompts/promise_generation.txt');
        if (!File::exists($templatePath)) {
            throw new \Exception("Prompt template not found at {$templatePath}");
        }

        $template = File::get($templatePath);
        
        $q1 = $answers[0] ?? '';
        $q2 = $answers[1] ?? '';
        $q3 = $answers[2] ?? '';
        $q4 = $answers[3] ?? '';
        $q5 = $answers[4] ?? '';

        return str_replace(
            ['{{Q1}}', '{{Q2}}', '{{Q3}}', '{{Q4}}', '{{Q5}}'],
            [$q1, $q2, $q3, $q4, $q5],
            $template
        );
    }
}
