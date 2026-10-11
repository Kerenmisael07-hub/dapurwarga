@php
    $headerUser = auth()->user();
    $headerName = $headerUser->name ?? 'Pengguna';
    $headerInitial = strtoupper(mb_substr($headerName, 0, 1));
@endphp
<header class="bg-surface-container-lowest border-t border-slate-700 border-b border-slate-200/70 shadow-[0_1px_2px_rgba(15,23,42,0.04)] px-margin-mobile md:px-gutter py-3 flex items-center justify-between gap-3 z-30 sticky top-0">
    <div class="flex items-center gap-2 min-w-0">
        @if (! empty($mobileNavId))
            <button type="button" class="md:hidden text-on-surface-variant shrink-0" onclick="document.getElementById('{{ $mobileNavId }}').classList.toggle('hidden')" aria-label="Menu">
                <span class="material-symbols-outlined">menu</span>
            </button>
        @endif
        <span class="rounded-md bg-[#F8FAFC] px-3 py-1.5 text-label-md font-label-md text-[#3B82F6]">Welcome</span>
    </div>
    <div class="flex items-center gap-2.5 shrink-0">
        <p class="hidden sm:block text-label-md font-label-md text-slate-400">Hi, <span class="font-bold text-primary">{{ $headerName }}</span></p>
        <span class="w-9 h-9 rounded-lg bg-[#CFFAFE] flex items-center justify-center font-bold text-[#0891B2]">{{ $headerInitial }}</span>
        @if (empty($mobileNavId))
            <form method="POST" action="{{ route('logout') }}" class="shrink-0">
                @csrf
                <button type="submit" title="Keluar" class="flex items-center text-slate-400 hover:text-error transition-colors">
                    <span class="material-symbols-outlined">logout</span>
                </button>
            </form>
        @endif
    </div>
</header>
