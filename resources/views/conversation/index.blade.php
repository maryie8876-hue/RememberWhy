<x-layouts.app>
    <div class="min-h-screen flex flex-col justify-center items-center py-24 px-6 md:px-12">
        <div class="w-full max-w-2xl px-6 mx-auto">
            
            <x-logo class="mb-10" />
            
            <div class="progress-track mb-12">
                @for ($i = 1; $i <= $total; $i++)
                    <span @class([
                        'progress-segment',
                        'is-complete' => $i < $step,
                        'is-current' => $i == $step,
                    ])></span>
                @endfor
            </div>
            
            <form action="{{ route('conversation.store') }}" method="POST" class="w-full">
                @csrf
                
                <h2 class="text-3xl sm:text-5xl font-serif font-medium text-ink-primary mb-12 leading-snug text-center whitespace-pre-line tracking-tight">
                    {{ $question }}
                </h2>
                
                <div class="mb-12">
                    <textarea 
                        id="answer"
                        name="answer" 
                        rows="3"
                        autofocus
                        placeholder="Take your time..."
                        class="field-writing"
                    >{{ $currentAnswer }}</textarea>
                </div>
                
                <div class="flex items-center justify-between">
                    <div>
                        @if($step > 1)
                            <x-text-link href="{{ route('conversation.index', ['step' => $step - 1]) }}">
                                Back
                            </x-text-link>
                        @endif
                    </div>
                    
                    <x-button type="submit">
                        Continue
                    </x-button>
                </div>
            </form>
            
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const textarea = document.getElementById('answer');
            if (!textarea) return;

            const grow = () => {
                textarea.style.height = 'auto';
                textarea.style.height = Math.min(textarea.scrollHeight, 384) + 'px';
            };

            textarea.addEventListener('input', grow);
            grow();
        });
    </script>
</x-layouts.app>
