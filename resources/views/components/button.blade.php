@props([
    'variant' => 'primary',
])

@php
    $base = 'inline-flex items-center justify-center font-serif tracking-wide rounded-full transition-all duration-300 ease-[cubic-bezier(0.4,0,0.2,1)] focus:outline-none focus-visible:ring-2 focus-visible:ring-accent/30 focus-visible:ring-offset-2 focus-visible:ring-offset-paper disabled:opacity-40 disabled:cursor-not-allowed active:scale-[0.98]';

    $variants = [
        'primary' => 'px-9 py-3.5 text-base border border-transparent text-surface bg-accent hover:bg-accent/85',
        'quiet' => 'px-9 py-3.5 text-base border border-ink-secondary/20 text-ink-primary bg-transparent hover:border-accent/40 hover:bg-accent/5',
        'secondary' => 'px-0 py-2 text-lg border-0 bg-transparent text-ink-secondary/70 hover:text-ink-primary rounded-none active:scale-100',
    ];
@endphp

<button {{ $attributes->merge(['class' => $base . ' ' . ($variants[$variant] ?? $variants['primary'])]) }}>
    {{ $slot }}
</button>
