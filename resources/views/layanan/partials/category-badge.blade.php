@php
    $c = strtolower($category);
    [$emoji, $class] = match (true) {
        str_contains($c, 'galon') || str_contains($c, 'air') || str_contains($c, 'antar') => ['💧', 'bg-sky-100 text-sky-700'],
        str_contains($c, 'listrik') || str_contains($c, 'perbaikan') || str_contains($c, 'pertukangan') || str_contains($c, 'bangun') || str_contains($c, 'konstruksi') => ['🔌', 'bg-orange-100 text-orange-700'],
        str_contains($c, 'pipa') || str_contains($c, 'plumbing') || str_contains($c, 'ledeng') => ['🚰', 'bg-cyan-100 text-cyan-700'],
        str_contains($c, 'mesin') || str_contains($c, 'pompa') => ['⚙️', 'bg-slate-200 text-slate-700'],
        str_contains($c, 'les') || str_contains($c, 'pendidikan') || str_contains($c, 'kursus') => ['📚', 'bg-violet-100 text-violet-700'],
        str_contains($c, 'rumah tangga') || str_contains($c, 'bersih') => ['🧹', 'bg-emerald-100 text-emerald-700'],
        str_contains($c, 'kecantikan') || str_contains($c, 'cantik') || str_contains($c, 'salon') => ['💅', 'bg-pink-100 text-pink-700'],
        str_contains($c, 'kesehatan') || str_contains($c, 'sehat') => ['🩺', 'bg-teal-100 text-teal-700'],
        default => ['🛠️', 'bg-surface-container-high text-on-surface-variant'],
    };
@endphp
<span class="{{ $class }} text-[11px] font-semibold px-2 py-0.5 rounded-full inline-flex items-center gap-1 min-w-0">
    <span>{{ $emoji }}</span>
    <span class="truncate">{{ $category }}</span>
</span>
