<x-layouts.app>
    <div class="min-h-screen flex flex-col justify-center items-center py-24 px-6 md:px-12">
        <div class="w-full max-w-2xl px-6 mx-auto text-center">
            
            <x-logo size="lg" class="mb-10" />
            
            <span class="text-eyebrow block">
                Remember Why
            </span>
            
            <h1 class="text-display text-ink-primary mt-10 mb-8">
                Before you begin...
            </h1>
            
            <p class="font-serif text-lg text-ink-secondary/80 mb-4 tracking-wide">
                When motivation fades, it's easy to forget why you started.
            </p>
            
            <p class="font-serif text-xl md:text-2xl text-ink-secondary leading-[1.8] mb-16 tracking-wide">
                Write it down now — and return to it when you need it.
            </p>
            
            <a href="{{ route('conversation.start') }}" class="inline-block focus:outline-none focus-visible:ring-2 focus-visible:ring-accent/30 focus-visible:ring-offset-2 focus-visible:ring-offset-paper rounded-full">
                <x-button>
                    Begin
                </x-button>
            </a>

        </div>
    </div>
</x-layouts.app>
