<x-layouts.app>
    <div class="min-h-screen flex flex-col justify-center items-center py-24 px-6 md:px-12">
        <div class="w-full max-w-2xl px-6 mx-auto text-center">
            
            <x-logo class="mb-10" />

            @if(session('error'))
                <div class="mb-12">
                    <h1 class="text-3xl sm:text-4xl font-serif font-medium text-ink-primary mb-8 leading-relaxed">
                        {{ session('error') }}
                    </h1>
                    <a href="{{ route('promise.generate') }}" class="inline-block focus:outline-none focus-visible:ring-2 focus-visible:ring-accent/30 focus-visible:ring-offset-2 focus-visible:ring-offset-paper rounded-full">
                        <x-button>
                            Retry
                        </x-button>
                    </a>
                </div>
            @else
                <h1 class="text-3xl sm:text-4xl font-serif font-medium text-ink-primary mb-8 leading-tight tracking-tight">
                    Writing your promise...
                </h1>
                
                <div class="space-y-3 font-serif text-xl text-ink-secondary/70 leading-relaxed mb-12">
                    <p class="italic">Take a breath.</p>
                    <p>We're preserving this moment.</p>
                </div>

                <div class="flex justify-center gap-3 mt-8">
                    <div class="w-1.5 h-1.5 rounded-full bg-ink-secondary/40 breathe-dot"></div>
                    <div class="w-1.5 h-1.5 rounded-full bg-ink-secondary/40 breathe-dot"></div>
                    <div class="w-1.5 h-1.5 rounded-full bg-ink-secondary/40 breathe-dot"></div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        setTimeout(() => {
                            window.location.replace("{{ route('promise.generate') }}");
                        }, 1000);
                    });
                </script>
            @endif
            
        </div>
    </div>
</x-layouts.app>
