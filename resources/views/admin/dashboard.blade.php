<!DOCTYPE html>
<html lang="id"><head>
@include('admin.partials.head', ['title' => 'Dashboard Admin'])
</head>
<body class="bg-surface text-on-surface h-screen flex overflow-hidden">
@include('admin.partials.sidebar', ['active' => 'dashboard'])
<main class="flex-1 flex flex-col h-full overflow-hidden bg-background">
@include('admin.partials.nav', ['active' => 'dashboard'])
<div class="flex-1 overflow-y-auto p-margin-mobile md:p-gutter">
    <div class="max-w-container-max mx-auto space-y-stack-lg pb-section-gap">
        <div>
            <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary">Dashboard Admin</h1>
            <p class="font-body-md text-body-md text-on-surface-variant mt-1">Ringkasan pengguna dan moderasi konten platform DapurWarga.</p>
        </div>

        <!-- Pengguna -->
        <section class="space-y-3">
            <h2 class="font-headline-md text-headline-md text-primary">Pengguna</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @php
                    $cards = [
                        ['Total Pengguna', $userCount, 'group', 'text-primary'],
                        ['Aktif', $activeUserCount, 'check_circle', 'text-[#0F5132]'],
                        ['Nonaktif', $inactiveUserCount, 'block', 'text-error'],
                        ['Admin', $adminCount, 'shield_person', 'text-primary'],
                        ['Penjual', $sellerCount, 'storefront', 'text-primary'],
                        ['Penyedia Jasa', $layananCount, 'home_repair_service', 'text-primary'],
                    ];
                @endphp
                @foreach ($cards as [$label, $value, $icon, $color])
                    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4">
                        <div class="flex items-center justify-between">
                            <span class="font-caption text-caption text-on-surface-variant">{{ $label }}</span>
                            <span class="material-symbols-outlined {{ $color }} text-[20px]">{{ $icon }}</span>
                        </div>
                        <p class="font-headline-lg text-headline-lg text-on-surface mt-2">{{ number_format($value) }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Konten -->
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-5">
                <h2 class="font-headline-md text-headline-md text-primary mb-4">Kuliner</h2>
                <div class="grid grid-cols-3 gap-4">
                    <div><p class="font-caption text-caption text-on-surface-variant">Menu</p><p class="font-headline-md text-headline-md">{{ number_format($menuCount) }}</p></div>
                    <div><p class="font-caption text-caption text-on-surface-variant">Lapak Buka</p><p class="font-headline-md text-headline-md text-[#0F5132]">{{ number_format($lapakBuka) }}</p></div>
                    <div><p class="font-caption text-caption text-on-surface-variant">Penjual</p><p class="font-headline-md text-headline-md">{{ number_format($sellerCount) }}</p></div>
                </div>
            </div>
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-5">
                <h2 class="font-headline-md text-headline-md text-primary mb-4">Layanan Jasa</h2>
                <div class="grid grid-cols-3 gap-4">
                    <div><p class="font-caption text-caption text-on-surface-variant">Layanan</p><p class="font-headline-md text-headline-md">{{ number_format($serviceCount) }}</p></div>
                    <div><p class="font-caption text-caption text-on-surface-variant">Tersedia</p><p class="font-headline-md text-headline-md text-[#0F5132]">{{ number_format($serviceTersedia) }}</p></div>
                    <div><p class="font-caption text-caption text-on-surface-variant">Sibuk</p><p class="font-headline-md text-headline-md text-error">{{ number_format($serviceSibuk) }}</p></div>
                </div>
            </div>
        </section>

        <!-- Pengguna Terbaru -->
        <section class="bg-surface-container-lowest border border-outline-variant rounded-xl p-5">
            <h2 class="font-headline-md text-headline-md text-primary mb-3">Pengguna Terbaru</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @forelse ($recentUsers as $u)
                    <div class="flex items-center justify-between gap-2 text-sm border border-outline-variant rounded-lg px-3 py-2">
                        <span class="truncate">{{ $u->name }}</span>
                        <span class="text-xs text-on-surface-variant uppercase">{{ $u->role }}</span>
                    </div>
                @empty
                    <p class="text-sm text-on-surface-variant">Belum ada data.</p>
                @endforelse
            </div>
        </section>
    </div>
</div>
</main>
</body></html>