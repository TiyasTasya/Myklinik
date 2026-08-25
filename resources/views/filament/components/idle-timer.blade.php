@auth
    @if (! session('is_locked') && request()->route()?->getName() !== 'filament.admin.pages.lockscreen')
        @php
            $timeoutMinutes = \App\Models\Pengaturan::getLockTimeoutMinutes();
            $timeoutMs = ($timeoutMinutes > 0 ? $timeoutMinutes : 5) * 60 * 1000;
        @endphp
        <script>
            (function() {
                const idleTimeout = {{ $timeoutMs }};
                const lockscreenUrl = "{{ route('filament.admin.pages.lockscreen') }}";
                let lastActivity = Date.now();
                let timer = null;

                function resetTimer() {
                    lastActivity = Date.now();
                }

                function checkIdle() {
                    const elapsed = Date.now() - lastActivity;
                    if (elapsed >= idleTimeout) {
                        window.location.href = lockscreenUrl;
                    }
                }

                const events = ['mousemove', 'mousedown', 'keydown', 'scroll', 'touchstart', 'click'];
                events.forEach(function(evt) {
                    window.addEventListener(evt, resetTimer, { passive: true });
                });

                document.addEventListener('visibilitychange', function() {
                    if (!document.hidden) {
                        checkIdle();
                    }
                });

                // Periksa setiap 5 detik
                timer = setInterval(checkIdle, 5000);
            })();
        </script>
    @endif
@endauth

