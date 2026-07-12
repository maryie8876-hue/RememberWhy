<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConversationController extends Controller
{
    private array $questions = [
        "What are you building?",
        "Why does this project matter to you?",
        "What are you hoping this project becomes?",
        "When this project becomes difficult...\nwhat might make you stop?",
        "If your future self could remember only one thing...\nwhat should it be?"
    ];

    public function start(Request $request)
    {
        $request->session()->forget([
            'conversation_step',
            'conversation_answers',
            'generated_promise'
        ]);
        
        return redirect()->route('conversation.index');
    }

    public function index(Request $request)
    {
        $currentSessionStep = $request->session()->get('conversation_step', 0);
        $requestedStep = $request->query('step');
        
        $step = $currentSessionStep;
        
        if ($requestedStep !== null && is_numeric($requestedStep)) {
            $targetStep = (int)$requestedStep - 1;
            if ($targetStep >= 0 && $targetStep <= $currentSessionStep) {
                $step = $targetStep;
                $request->session()->put('conversation_step', $step);
            }
        }

        if ($step >= count($this->questions)) {
            return redirect()->route('reflection.index');
        }

        $answers = $request->session()->get('conversation_answers', []);
        $currentAnswer = $answers[$step] ?? '';

        return view('conversation.index', [
            'question' => $this->questions[$step],
            'step' => $step + 1,
            'total' => count($this->questions),
            'currentAnswer' => $currentAnswer
        ]);
    }

    public function store(Request $request)
    {
        $step = $request->session()->get('conversation_step', 0);
        $answers = $request->session()->get('conversation_answers', []);

        $answers[$step] = $request->input('answer', '');

        $request->session()->put('conversation_answers', $answers);
        $request->session()->put('conversation_step', $step + 1);

        if ($step + 1 >= count($this->questions)) {
            return redirect()->route('reflection.index');
        }

        return redirect()->route('conversation.index');
    }
}
