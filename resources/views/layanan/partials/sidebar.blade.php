@php
    $user = auth()->user();
    $navItems = [
        'dashboard' => ['route' => 'layanan.dashboard', 'icon' => 'home_repair_service', 'label' => 'Beranda Layanan'],
        'create' => ['route' => 'layanan.create', 'icon' => 'add_circle', 'label' => 'Tambah Layanan'],
        'pesanan' => ['route' => 'layanan.pesanan.index', 'icon' => 'receipt_long', 'label' => 'Pesanan Warga'],
        'pengaturan' => ['route' => 'layanan.pengaturan.edit', 'icon' => 'settings', 'label' => 'Pengaturan'],
        'katalog' => ['route' => 'layanan', 'icon' => 'storefront', 'label' => 'Lihat Katalog'],
    ];
@endphp
<aside class="w-64 bg-surface-container-lowest border-r border-outline-variant flex flex-col hidden md:flex h-full">
    <div class="p-gutter border-b border-outline-variant">
        <div class="text-headline-md font-headline-md font-bold text-primary flex items-center gap-2">
            DapurWarga
        </div>
        <p class="font-caption text-caption text-on-surface-variant mt-1">Dasbor Penyedia Jasa</p>
    </div>
    <nav class="flex-1 py-stack-md px-stack-sm flex flex-col gap-2 overflow-y-auto">
        @foreach ($navItems as $key => $item)
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg font-label-md text-label-md transition-colors {{ ($active ?? 'dashboard') === $key ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-container hover:text-primary' }}" href="{{ route($item['route']) }}">
                <span class="material-symbols-outlined">{{ $item['icon'] }}</span>
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>
    <div class="p-gutter border-t border-outline-variant mt-auto">
        <div class="flex items-center gap-3">
            @include('partials.avatar', [
                'user' => $user,
                'size' => 'w-10 h-10',
                'textClass' => 'text-sm',
                'ring' => '',
                'fallback' => 'bg-primary-container text-on-primary-container',
            ])
            <div class="flex-grow min-w-0">
                <p class="font-label-md text-label-md text-on-surface truncate">{{ $user->name }}</p>
                <p class="font-caption text-caption text-on-surface-variant truncate">{{ $user->nama_lapak ?: 'Penyedia Jasa' }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button type="submit" class="w-full font-label-md text-label-md text-on-surface-variant hover:text-error transition-colors flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[18px]">logout</span> Keluar
            </button>
        </form>
    </div>
</aside>
