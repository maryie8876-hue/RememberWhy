<a {{ $attributes->merge(['class' => 'font-serif text-lg text-ink-secondary/70 hover:text-ink-primary transition-colors duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-accent/30 focus-visible:ring-offset-2 focus-visible:ring-offset-paper rounded-sm']) }}>
    {{ $slot }}
</a>
