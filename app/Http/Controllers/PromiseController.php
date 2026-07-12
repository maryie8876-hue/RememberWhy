<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PromiseGenerator;
use App\Models\Promise;
use App\Models\InterviewAnswer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PromiseController extends Controller
{
    private array $questions = [
        "What are you building?",
        "Why does this project matter to you?",
        "What are you hoping this project becomes?",
        "When this project becomes difficult...\nwhat might make you stop?",
        "If your future self could remember only one thing...\nwhat should it be?"
    ];

    public function generate(Request $request, PromiseGenerator $generator)
    {
        $answers = $request->session()->get('conversation_answers', []);

        if (count($answers) < 5) {
            return redirect()->route('conversation.index');
        }

        try {
            $generatedText = $generator->generatePromise($answers);

            $promise = DB::transaction(function () use ($answers, $generatedText) {
                $promise = Promise::create([
                    'project_title' => $answers[0] ?? null,
                    'generated_promise' => $generatedText,
                ]);

                foreach ($answers as $index => $answerText) {
                    InterviewAnswer::create([
                        'promise_id'      => $promise->id,
                        'question_number' => $index + 1,
                        'question'        => $this->questions[$index] ?? '',
                        'answer'          => $answerText,
                    ]);
                }

                return $promise;
            });

            // Clear session now that data is persisted
            $request->session()->forget([
                'conversation_step',
                'conversation_answers',
                'generated_promise',
            ]);

            return redirect()
                ->route('promise.show', ['uuid' => $promise->uuid])
                ->with('just_created', true);

        } catch (\Exception $e) {
            Log::error("Promise generation failed: " . $e->getMessage());
            return redirect()->route('reflection.index')
                ->with('error', 'We couldn\'t finish writing your promise. Let\'s try again.');
        }
    }

    public function show(Request $request, string $uuid)
    {
        $promise = Promise::where('uuid', $uuid)->first();

        if (!$promise) {
            abort(404);
        }

        return view('promise.show', [
            'promise'      => $promise->generated_promise,
            'uuid'         => $promise->uuid,
            'createdAt'    => $promise->created_at->format('F j, Y'),
            'isSealed'     => !is_null($promise->sealed_at),
            'justCreated'  => session('just_created', false),
        ]);
    }

    public function seal(Request $request, string $uuid)
    {
        $promise = Promise::where('uuid', $uuid)->first();

        if (!$promise) {
            abort(404);
        }

        if (!$promise->sealed_at) {
            $promise->update(['sealed_at' => now()]);
        }

        return response()->json(['status' => 'sealed']);
    }

    public function saveEmail(Request $request, string $uuid)
    {
        $promise = Promise::where('uuid', $uuid)->first();

        if (!$promise) {
            return response()->json(['error' => 'Promise not found.'], 404);
        }

        $validated = $request->validate([
            'email'      => ['required', 'email', 'max:255'],
            'remind_at'  => ['required', 'in:1week,1month,3months'],
        ]);

        $remindAt = match($validated['remind_at']) {
            '1week'   => now()->addWeek(),
            '1month'  => now()->addMonth(),
            '3months' => now()->addMonths(3),
        };

        $promise->update([
            'email'     => $validated['email'],
            'remind_at' => $remindAt,
        ]);

        return response()->json([
            'status'  => 'saved',
            'message' => "We'll be here when you need it.",
        ]);
    }
}
