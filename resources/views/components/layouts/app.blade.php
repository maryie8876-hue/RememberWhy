<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Remember Why') }}</title>

        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 24 24' fill='none' stroke='%23756A5C' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M12.67 19a2 2 0 0 0 1.416-.588l6.154-6.172a6 6 0 0 0-8.49-8.49L5.586 9.914A2 2 0 0 0 5 11.328V18a1 1 0 0 0 1 1z'/%3E%3Cpath d='M16 8 2 22'/%3E%3Cpath d='M17.5 15H9'/%3E%3C/svg%3E">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="text-ink-primary font-serif min-h-screen selection:bg-accent/20 selection:text-ink-primary">
        <main id="page-content" class="opacity-0 page-transition">
            {{ $slot }}
        </main>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const pageContent = document.getElementById('page-content');
                const fadeDuration = 350;
                
                requestAnimationFrame(() => {
                    pageContent.classList.remove('opacity-0');
                    pageContent.classList.add('opacity-100');
                });

                document.querySelectorAll('a:not([target="_blank"]):not([href^="#"])').forEach(link => {
                    link.addEventListener('click', e => {
                        if (e.ctrlKey || e.metaKey || e.shiftKey || e.altKey) return;
                        if (link.hasAttribute('data-no-fade')) return;
                        
                        e.preventDefault();
                        const href = link.getAttribute('href');
                        
                        pageContent.classList.remove('opacity-100');
                        pageContent.classList.add('opacity-0');
                        
                        setTimeout(() => window.location.href = href, fadeDuration);
                    });
                });

                document.querySelectorAll('form:not([data-no-fade])').forEach(form => {
                    form.addEventListener('submit', () => {
                        pageContent.classList.remove('opacity-100');
                        pageContent.classList.add('opacity-0');
                    });
                });
            });
        </script>
    </body>
</html>
