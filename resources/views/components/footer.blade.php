<footer class="flex-shrink-0 h-[73px] border-t border-stone-200 bg-white px-6">
    <div class="flex h-full flex-col items-center justify-center gap-1 sm:flex-row sm:justify-between">

        {{-- Left: App name + version --}}
        <p class="text-[11.5px] text-stone-400">
            <span class="font-semibold text-stone-500">{{ config('app.name', 'PM-PUTP') }}</span>
            {{ config('app.version') }}
        </p>

        {{-- Center: Copyright --}}
        <p class="text-[11.5px] text-stone-400">
            2026 IT YKBS. All rights reserved.
        </p>

        {{-- Right: Live clock --}}
        <p class="text-[11.5px] text-stone-400" id="footer-clock"></p>

        <script>
            (function () {
                const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
                function tick() {
                    const now = new Date();
                    const day = days[now.getDay()];
                    const hh  = String(now.getHours()).padStart(2, '0');
                    const mm  = String(now.getMinutes()).padStart(2, '0');
                    const ss  = String(now.getSeconds()).padStart(2, '0');
                    const el  = document.getElementById('footer-clock');
                    if (el) el.innerHTML =
                        `<span class="font-medium text-stone-500">${day}</span>`
                        + ` &mdash; ${hh}<span class="text-orange-400">:</span>${mm}<span class="text-orange-400">:</span>${ss}`;
                }
                tick();
                setInterval(tick, 1000);
            })();
        </script>

    </div>
</footer>