<x-layouts.app>
    {{--
      State machine (JS-driven, no page reload):
        [welcome-back]  →  [promise + action-area]
        The action area has its own internal states:
          [seal]  →  [keep-safe]  →  [saved]
    --}}

    {{-- ════════════════════════════════════════
         WELCOME BACK INTRO
    ════════════════════════════════════════ --}}
    <div
        id="welcome-back"
        class="min-h-screen flex flex-col justify-center items-center px-6 py-24 transition-opacity duration-700 ease-in-out {{ $justCreated ? 'hidden opacity-0' : 'opacity-100' }}"
    >
        <div class="w-full max-w-[520px] mx-auto text-center">
            
            <x-logo class="mb-10" />
            
            <span class="text-eyebrow block">
                Remember Why
            </span>

            <h1 class="text-display text-ink-primary mt-10 mb-8">
                Welcome back.
            </h1>

            <p class="font-serif text-xl text-ink-secondary leading-[1.9] mb-14">
                Some promises are meant to be read more than once.
                <br><br>
                Take a moment.<br>Read this slowly.
            </p>

            <div class="cta-stagger">
                <x-button id="open-promise-btn" variant="quiet">
                    Open My Promise
                </x-button>
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════
         PROMISE BODY
    ════════════════════════════════════════ --}}
    <div
        id="promise-body"
        class="transition-opacity duration-700 ease-in-out {{ $justCreated ? 'opacity-100' : 'opacity-0 hidden' }}"
    >
        <div class="min-h-screen flex flex-col justify-center items-center py-24 px-6 md:px-12">
            <div class="w-full max-w-[760px] mx-auto">
                
                <x-logo size="sm" class="mb-12" />

                {{-- Metadata --}}
                <div class="flex items-center gap-4 mb-10">
                    <span class="text-meta">
                        Created {{ $createdAt }}
                    </span>
                    @if($isSealed)
                        <span class="inline-flex items-center gap-1.5 text-xs font-sans tracking-widest uppercase text-ink-secondary/70">
                            <span class="w-1.5 h-1.5 rounded-full bg-success inline-block"></span>
                            Sealed
                        </span>
                    @endif
                </div>

                {{-- The Promise Letter --}}
                <div class="letter-page">
                    <div class="relative pl-6 md:pl-8">
                        <div class="letter-rule"></div>
                        <div class="text-left letter-body tracking-wide whitespace-pre-wrap">
                            {{ trim($promise) }}
                        </div>
                    </div>
                </div>

                {{-- Action Area --}}
                <div class="mt-24 text-center relative min-h-[12rem]">

                    {{-- Step 1: Seal button --}}
                    @if(!$isSealed)
                    <div id="step-seal" class="absolute inset-x-0 top-0 transition-opacity duration-1000 ease-in-out opacity-100 flex justify-center">
                        <x-button
                            id="seal-btn"
                            variant="quiet"
                            data-seal-url="{{ route('promise.seal', ['uuid' => $uuid]) }}"
                        >
                            Seal My Promise
                        </x-button>
                    </div>
                    @endif

                    {{-- Step 2: Keep This Safe --}}
                    <div id="step-keep" class="absolute inset-x-0 top-0 transition-opacity duration-1000 ease-in-out {{ $isSealed ? 'opacity-100' : 'opacity-0 pointer-events-none' }} flex flex-col items-center">
                        <p class="font-serif text-2xl md:text-3xl text-ink-primary mb-4 leading-snug">
                            Your promise is safe.
                        </p>
                        <p class="font-serif text-lg text-ink-secondary mb-10 leading-relaxed max-w-md">
                            Go build something your future self will thank you for.
                            <br><br>
                            We can remind you why you started, when it matters most.
                        </p>
                        <div class="flex flex-col items-center gap-8">
                            <x-button id="keep-safe-btn">Keep This Safe</x-button>
                            <x-text-link href="{{ route('home') }}">
                                Back to the project
                            </x-text-link>
                        </div>
                    </div>

                    {{-- Step 3: Reminder saved --}}
                    <div id="step-saved" class="absolute inset-x-0 top-0 transition-opacity duration-1000 ease-in-out opacity-0 pointer-events-none flex flex-col items-center">
                        <p id="saved-message" class="font-serif text-2xl md:text-3xl text-ink-primary mb-10">
                            We'll be here when you need it.
                        </p>
                        <x-text-link href="{{ route('home') }}">
                            Back to the project
                        </x-text-link>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════
         REMINDER MODAL
    ════════════════════════════════════════ --}}
    <div
        id="email-modal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="modal-title"
        class="fixed inset-0 z-50 flex items-center justify-center px-6 opacity-0 pointer-events-none transition-opacity duration-300 ease-in-out"
    >
        <div id="modal-backdrop" class="absolute inset-0 bg-ink-primary/15"></div>

        <div id="modal-panel" class="relative bg-surface rounded-3xl px-10 py-12 w-full max-w-md border border-ink-secondary/10 transition-opacity duration-300 ease-in-out">

            {{-- Panel A: Timing selection --}}
            <div id="modal-panel-timing">
                <h2 id="modal-title" class="font-serif text-2xl text-ink-primary mb-3 leading-snug">
                    When should we remind you why you started?
                </h2>
                <p class="font-serif text-ink-secondary text-base leading-relaxed mb-8">
                    We will only ever send you this one reminder.
                </p>

                <div class="flex flex-col">
                    <button data-remind="1week" class="remind-option modal-option">
                        In one week
                    </button>
                    <button data-remind="1month" class="remind-option modal-option">
                        In one month
                    </button>
                    <button data-remind="3months" class="remind-option modal-option">
                        In three months
                    </button>
                </div>

                <div class="text-center mt-10">
                    <x-button id="modal-close" variant="secondary" type="button" class="text-sm text-ink-secondary/50 hover:text-ink-secondary">
                        Maybe later
                    </x-button>
                </div>
            </div>

            {{-- Panel B: Email entry --}}
            <div id="modal-panel-email" class="hidden">
                <button id="modal-back" class="flex items-center gap-2 text-ink-secondary/70 hover:text-ink-primary transition-colors duration-200 text-sm font-sans mb-6 focus:outline-none focus-visible:ring-2 focus-visible:ring-accent/30 focus-visible:ring-offset-2 focus-visible:ring-offset-surface rounded-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><path d="m12 19-7-7 7-7"/></svg>
                    Back
                </button>

                <h2 class="font-serif text-2xl text-ink-primary mb-3 leading-snug">
                    Where should we send it?
                </h2>
                <p id="modal-timing-label" class="font-serif text-ink-secondary text-base leading-relaxed mb-8">
                    We will only use your email for this reminder.
                </p>

                <form id="email-form" data-no-fade novalidate>
                    <div class="mb-6">
                        <label for="email-input" class="sr-only">Email address</label>
                        <input
                            id="email-input"
                            type="email"
                            name="email"
                            autocomplete="email"
                            placeholder="your@email.com"
                            class="field-email"
                        >
                        <p id="email-error" class="mt-2 text-sm font-sans text-error hidden">Please enter a valid email address.</p>
                    </div>
                    <x-button type="submit" id="save-email-btn" class="w-full justify-center">
                        Keep This Safe
                    </x-button>
                </form>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const csrfToken   = document.querySelector('meta[name="csrf-token"]').content;
            const justCreated = @json($justCreated);

            const welcomeBack     = document.getElementById('welcome-back');
            const promiseBody     = document.getElementById('promise-body');
            const openBtn         = document.getElementById('open-promise-btn');
            const sealBtn         = document.getElementById('seal-btn');
            const stepSeal        = document.getElementById('step-seal');
            const stepKeep        = document.getElementById('step-keep');
            const stepSaved       = document.getElementById('step-saved');
            const keepSafeBtn     = document.getElementById('keep-safe-btn');
            const emailModal      = document.getElementById('email-modal');
            const modalPanel      = document.getElementById('modal-panel');
            const modalPanelTiming = document.getElementById('modal-panel-timing');
            const modalPanelEmail  = document.getElementById('modal-panel-email');
            const modalClose      = document.getElementById('modal-close');
            const modalBack       = document.getElementById('modal-back');
            const emailForm       = document.getElementById('email-form');
            const emailInput      = document.getElementById('email-input');
            const emailError      = document.getElementById('email-error');
            const saveEmailBtn    = document.getElementById('save-email-btn');
            const modalTimingLabel = document.getElementById('modal-timing-label');

            const sealUrl  = sealBtn ? sealBtn.dataset.sealUrl : null;
            const emailUrl = '{{ route('promise.save-email', ['uuid' => $uuid]) }}';

            let selectedRemindAt = null;

            const timingLabels = {
                '1week':   "We'll send your reminder in one week.",
                '1month':  "We'll send your reminder in one month.",
                '3months': "We'll send your reminder in three months.",
            };

            // ─── Welcome Back ───────────────────────────────
            if (openBtn) {
                openBtn.addEventListener('click', function () {
                    openBtn.disabled = true;
                    welcomeBack.classList.add('opacity-0');
                    setTimeout(() => {
                        welcomeBack.classList.add('hidden');
                        promiseBody.classList.remove('hidden');
                        window.scrollTo({ top: 0, behavior: 'instant' });
                        requestAnimationFrame(() => {
                            promiseBody.classList.remove('opacity-0');
                            promiseBody.classList.add('opacity-100');
                        });
                    }, 700);
                });
            }

            // ─── Seal ────────────────────────────────────────
            if (sealBtn && stepSeal) {
                sealBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    sealBtn.disabled = true;

                    fetch(sealUrl, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                    }).catch(() => {});

                    stepSeal.classList.add('opacity-0');
                    stepSeal.style.pointerEvents = 'none';

                    setTimeout(() => {
                        stepSeal.classList.add('hidden');
                        stepKeep.classList.remove('pointer-events-none', 'hidden');
                        requestAnimationFrame(() => {
                            stepKeep.classList.remove('opacity-0');
                            stepKeep.classList.add('opacity-100');
                        });
                    }, 1000);
                });
            }

            // ─── Modal helpers ──────────────────────────────
            function openModal() {
                modalPanelTiming.classList.remove('hidden');
                modalPanelEmail.classList.add('hidden');
                selectedRemindAt = null;

                emailModal.classList.remove('pointer-events-none', 'opacity-0');
                emailModal.classList.add('opacity-100');
            }

            function closeModal() {
                emailModal.classList.remove('opacity-100');
                emailModal.classList.add('opacity-0');
                setTimeout(() => emailModal.classList.add('pointer-events-none'), 300);
            }

            function showEmailPanel() {
                modalPanelTiming.classList.add('hidden');
                modalPanelEmail.classList.remove('hidden');
                if (modalTimingLabel) {
                    modalTimingLabel.textContent = timingLabels[selectedRemindAt] || 'We will only use your email for this reminder.';
                }
                emailInput.focus();
            }

            // ─── Timing option buttons ───────────────────────
            document.querySelectorAll('.remind-option').forEach(btn => {
                btn.addEventListener('click', function () {
                    selectedRemindAt = this.dataset.remind;
                    showEmailPanel();
                });
            });

            // ─── Modal open / close triggers ────────────────
            if (keepSafeBtn) keepSafeBtn.addEventListener('click', openModal);
            if (modalClose)  modalClose.addEventListener('click', closeModal);
            if (modalBack)   modalBack.addEventListener('click', () => {
                modalPanelEmail.classList.add('hidden');
                modalPanelTiming.classList.remove('hidden');
            });
            document.getElementById('modal-backdrop').addEventListener('click', closeModal);
            document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

            // ─── Email form submit ───────────────────────────
            if (emailForm) {
                emailForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    emailError.classList.add('hidden');

                    const email = emailInput.value.trim();
                    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                        emailError.classList.remove('hidden');
                        emailInput.focus();
                        return;
                    }

                    if (!selectedRemindAt) {
                        emailError.textContent = 'Please select a reminder time first.';
                        emailError.classList.remove('hidden');
                        return;
                    }

                    saveEmailBtn.disabled = true;
                    saveEmailBtn.textContent = 'Saving...';

                    fetch(emailUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ email, remind_at: selectedRemindAt })
                    })
                    .then(res => { if (!res.ok) throw new Error(); return res.json(); })
                    .then((data) => {
                        if (data.message) {
                            document.getElementById('saved-message').textContent = data.message;
                        }

                        closeModal();
                        setTimeout(() => {
                            stepKeep.classList.remove('opacity-100');
                            stepKeep.classList.add('opacity-0');
                            stepKeep.style.pointerEvents = 'none';
                            setTimeout(() => {
                                stepKeep.classList.add('hidden');
                                stepSaved.classList.remove('pointer-events-none', 'hidden');
                                requestAnimationFrame(() => {
                                    stepSaved.classList.remove('opacity-0');
                                    stepSaved.classList.add('opacity-100');
                                });
                            }, 1000);
                        }, 350);
                    })
                    .catch(() => {
                        saveEmailBtn.disabled = false;
                        saveEmailBtn.textContent = 'Keep This Safe';
                        emailError.textContent = 'Something went wrong. Please try again.';
                        emailError.classList.remove('hidden');
                    });
                });
            }
        });
    </script>
</x-layouts.app>
