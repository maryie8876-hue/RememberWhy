<x-layouts.app>
    <div class="min-h-screen flex flex-col justify-center items-center py-24 px-6 md:px-12">
        <div class="w-full max-w-[520px] mx-auto text-center">

            <x-logo class="mb-10" />

            <span class="text-eyebrow block">
                Remember Why
            </span>

            <h1 class="text-display text-ink-primary mt-10 mb-8 text-[clamp(1.875rem,4vw,2.5rem)]">
                This promise could not be found.
            </h1>

            <p class="font-serif text-xl text-ink-secondary leading-[1.9] mb-14">
                It may have been removed or the link is no longer valid.
            </p>

            <div class="flex flex-col items-center gap-8">
                <a href="{{ route('conversation.start') }}" class="inline-block focus:outline-none focus-visible:ring-2 focus-visible:ring-accent/30 focus-visible:ring-offset-2 focus-visible:ring-offset-paper rounded-full">
                    <x-button>
                        Start a New Promise
                    </x-button>
                </a>
                <x-text-link href="{{ route('home') }}">
                    Return home
                </x-text-link>
            </div>

        </div>
    </div>
</x-layouts.app>
