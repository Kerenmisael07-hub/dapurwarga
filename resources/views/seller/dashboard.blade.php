<!DOCTYPE html>
<html lang="id"><head>
@include('seller.partials.head', ['title' => 'Dashboard Penjual'])
</head>
<body class="bg-surface text-on-surface h-screen flex overflow-hidden">
@php
    $user = auth()->user();
    $days = ['SEN', 'SEL', 'RAB', 'KAM', 'JUM', 'SAB', 'MIN'];
@endphp
@include('seller.partials.sidebar', ['active' => 'dashboard'])
<!-- Main Content Area -->
<main class="flex-1 flex flex-col h-full overflow-hidden bg-background">
@include('seller.partials.nav', ['active' => 'dashboard'])
<!-- Content Canvas -->
<div class="flex-1 overflow-y-auto p-margin-mobile md:p-gutter">
    <div class="max-w-container-max mx-auto space-y-stack-lg pb-section-gap">
        @if (session('success'))
            <div class="bg-secondary-container text-on-secondary-container font-label-md text-label-md px-4 py-3 rounded-lg flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">check_circle</span>
                {{ session('success') }}
            </div>
        @endif
        @if (isset($errors) && $errors->any())
            <div class="bg-error-container text-on-error-container font-label-md text-label-md px-4 py-3 rounded-lg flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">error</span>
                Periksa kembali isian form.
            </div>
        @endif
        <!-- Page Header & Global Action -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary">Manajemen Lapak Saya</h1>
                <p class="font-body-md text-body-md text-on-surface-variant mt-1">Kelola menu masakan, pantau ketersediaan, dan atur operasional lapak Anda hari ini.</p>
            </div>
        </div>
        <!-- Stats & Status Widget Row -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-stack-md">
            <!-- Stat Card 1 -->
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-label-md text-label-md text-on-surface-variant">Total Menu Aktif</h3>
                    <span class="material-symbols-outlined text-primary-container bg-primary-fixed p-2 rounded-full">restaurant_menu</span>
                </div>
                <div>
                    <p class="font-display-lg text-display-lg text-on-surface">{{ $totalAktif }}</p>
                    <p class="font-caption text-caption text-on-surface-variant mt-1">Dari {{ $menus->count() }} menu</p>
                </div>
            </div>
            <!-- Stat Card 2 -->
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-label-md text-label-md text-on-surface-variant">Porsi Terjual</h3>
                    <span class="material-symbols-outlined text-secondary-container bg-secondary-fixed-dim p-2 rounded-full text-on-secondary-fixed">shopping_bag</span>
                </div>
                <div>
                    <p class="font-display-lg text-display-lg text-on-surface">{{ $totalTerjual }}</p>
                    <p class="font-caption text-caption text-on-surface-variant mt-1">Total porsi terjual</p>
                </div>
            </div>
            <!-- Status Toggle Card -->
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm flex flex-col justify-between relative overflow-hidden">
                <div class="absolute right-0 top-0 w-32 h-32 bg-primary-fixed/20 rounded-bl-full -z-10"></div>
                <div class="flex items-center justify-between mb-4 z-10">
                    <h3 class="font-label-md text-label-md text-on-surface-variant">Status Lapak</h3>
                    <span class="material-symbols-outlined {{ $user->lapak_buka ? 'text-secondary' : 'text-error' }}">store</span>
                </div>
                <div class="flex items-center justify-between z-10">
                    <div>
                        <p class="font-headline-md text-headline-md {{ $user->lapak_buka ? 'text-on-surface' : 'text-error' }}">{{ $user->lapak_buka ? 'Buka' : 'Tutup' }}</p>
                        <p class="font-caption text-caption {{ $user->lapak_buka ? 'text-on-surface-variant' : 'text-error' }} mt-1">{{ $user->lapak_buka ? 'Menerima pesanan' : 'Tidak menerima pesanan' }}</p>
                    </div>
                    <form method="POST" action="{{ route('seller.lapak.toggle') }}">
                        @csrf
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" onchange="this.form.submit()" {{ $user->lapak_buka ? 'checked' : '' }}>
                            <div class="w-14 h-7 bg-outline-variant peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:border-gray-300 after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-secondary"></div>
                        </label>
                    </form>
                </div>
            </div>
        </div>
        <!-- Menu Management Grid -->
        <div>
            <div class="flex items-center justify-between mb-stack-md">
                <h2 class="font-headline-md text-headline-md text-on-surface">Menu Harian Aktif</h2>
            </div>
            @if ($menus->isEmpty())
                <div class="bg-surface-container-lowest border border-dashed border-outline-variant rounded-xl p-stack-lg flex flex-col items-center justify-center text-center gap-4 min-h-[280px]">
                    <span class="material-symbols-outlined text-5xl text-on-surface-variant">restaurant_menu</span>
                    <div>
                        <h3 class="font-headline-md text-headline-md text-on-surface mb-1">Lapak Anda masih kosong</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">Tambahkan menu kuliner pertama Anda agar langsung tampil di beranda DapurWarga untuk tetangga sekitar.</p>
                    </div>
                    <a href="{{ route('seller.menu.create') }}" class="bg-primary text-on-primary px-6 py-3 rounded-lg font-label-md text-label-md flex items-center gap-2 hover:bg-primary/90 transition-colors">
                        <span class="material-symbols-outlined">add</span>
                        Tambah Menu Pertama
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-stack-md">
                    @foreach ($menus as $menu)
                    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow group flex flex-col">
                        <div class="relative aspect-square w-full bg-surface-container">
                            @if ($menu->image_url)
                                <img class="w-full h-full object-cover {{ $menu->available ? '' : 'grayscale-[30%]' }}" src="{{ $menu->image_url }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-surface-container-high">
                                    <span class="material-symbols-outlined text-5xl text-on-surface-variant">restaurant</span>
                                </div>
                            @endif
                            <div class="absolute top-3 left-3 {{ $menu->available ? 'bg-secondary text-on-secondary' : 'bg-error text-on-error' }} px-2 py-1 rounded text-xs font-bold uppercase tracking-wider">{{ $menu->available ? 'Tersedia' : 'Habis' }}</div>
                            <div class="absolute top-3 right-3 bg-surface-container-lowest/90 backdrop-blur-sm rounded-full p-1 border border-outline-variant shadow-sm flex opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('seller.menu.edit', $menu) }}" class="p-1 text-on-surface-variant hover:text-primary"><span class="material-symbols-outlined text-[18px]">edit</span></a>
                                <form method="POST" action="{{ route('seller.menu.destroy', $menu) }}" onsubmit="return confirm('Hapus menu ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 text-on-surface-variant hover:text-error"><span class="material-symbols-outlined text-[18px]">delete</span></button>
                                </form>
                            </div>
                        </div>
                        <div class="p-4 flex flex-col flex-grow">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-label-md text-label-md text-on-surface leading-tight">{{ $menu->name }}</h3>
                                <span class="font-label-md text-label-md text-primary whitespace-nowrap ml-2">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                            </div>
                            @if ($menu->description)
                                <p class="font-caption text-caption text-on-surface-variant mb-4 line-clamp-2">{{ $menu->description }}</p>
                            @endif
                            <div class="flex flex-wrap gap-1 mb-4">
                                @foreach ($days as $day)
                                    <span class="{{ in_array($day, $menu->days ?? []) ? 'bg-primary-fixed text-primary-container' : 'bg-surface-variant text-on-surface-variant' }} text-[10px] font-bold px-2 py-0.5 rounded-sm">{{ $day }}</span>
                                @endforeach
                            </div>
                            <div class="flex items-center justify-between pt-3 border-t border-outline-variant mt-auto gap-2">
                                <div class="flex items-center gap-1">
                                    <form method="POST" action="{{ route('seller.menu.stock', $menu) }}">
                                        @csrf
                                        <input type="hidden" name="direction" value="kurang">
                                        <button type="submit" title="Kurangi 1 porsi (ada pembelian)" @disabled($menu->stock === 0) class="w-8 h-8 flex items-center justify-center rounded-lg bg-surface-variant text-on-surface-variant hover:bg-error-container hover:text-on-error-container disabled:opacity-40 disabled:cursor-not-allowed transition-colors">
                                            <span class="material-symbols-outlined text-[18px]">remove</span>
                                        </button>
                                    </form>
                                    <div class="px-1.5 text-center min-w-[52px]">
                                        <span class="block font-label-md text-label-md leading-tight {{ $menu->stock === 0 ? 'text-error' : 'text-on-surface' }}"><span class="font-bold">{{ $menu->stock }}</span> porsi</span>
                                        <span class="block font-caption text-caption text-on-surface-variant leading-tight">{{ $menu->stock + $menu->sold }} total</span>
                                    </div>
                                    <form method="POST" action="{{ route('seller.menu.stock', $menu) }}">
                                        @csrf
                                        <input type="hidden" name="direction" value="tambah">
                                        <button type="submit" title="Tambah 1 porsi" class="w-8 h-8 flex items-center justify-center rounded-lg bg-surface-variant text-on-surface-variant hover:bg-primary-fixed hover:text-primary transition-colors">
                                            <span class="material-symbols-outlined text-[18px]">add</span>
                                        </button>
                                    </form>
                                </div>
                                <form method="POST" action="{{ route('seller.menu.toggle', $menu) }}">
                                    @csrf
                                    <button type="submit" class="{{ $menu->available ? 'text-primary bg-primary-fixed/50 hover:underline' : 'text-on-surface-variant bg-surface-variant hover:underline' }} font-label-md text-label-md px-3 py-1.5 rounded-md transition-colors">
                                        {{ $menu->available ? 'Tandai Habis' : 'Tersedia Lagi' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
</main>
</body></html>
