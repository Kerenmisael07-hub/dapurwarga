@extends('layouts.app')

@section('title', 'Jadwal Kuliner - DapurWarga')

@section('content')
    <div class="py-stack-lg md:py-section-gap grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-8 flex flex-col gap-8">
            <header class="flex flex-col gap-stack-sm border-b border-outline-variant pb-6">
                <h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary">Jadwal Kuliner Mingguan</h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant">Dukung tetangga kita dengan memesan sajian rumah tangga terbaik. Jadwal buka pre-order dan ketersediaan mingguan di area RT kita.</p>
            </header>

            <div class="flex flex-col gap-4">
                <div class="flex flex-wrap gap-2 items-center">
                    <span class="font-label-md text-label-md text-on-surface-variant mr-2">Urutkan:</span>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'populer']) }}"
                        class="press-anim px-4 py-1.5 rounded-full font-label-md text-label-md {{ $sort === 'populer' ? 'bg-primary text-on-primary' : 'border border-outline-variant text-on-surface hover:bg-surface-container-high transition-colors' }}">
                        Paling Disukai
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'terbaru']) }}"
                        class="press-anim px-4 py-1.5 rounded-full font-label-md text-label-md {{ $sort === 'terbaru' ? 'bg-primary text-on-primary' : 'border border-outline-variant text-on-surface hover:bg-surface-container-high transition-colors' }}">
                        Terbaru
                    </a>
                </div>
                <div class="flex flex-wrap gap-2 items-center">
                    <span class="font-label-md text-label-md text-on-surface-variant mr-2">Kategori:</span>
                    @foreach (['Semua' => null, 'Sarapan' => 'Sarapan', 'Makan Siang' => 'Makan Siang', 'Cemilan' => 'Cemilan', 'Lauk Pauk' => 'Lauk Pauk'] as $label => $category)
                        <a href="{{ request()->fullUrlWithQuery(['category' => $category, 'day' => $selectedDay]) }}"
                            class="press-anim px-4 py-1.5 rounded-full font-label-md text-label-md {{ $selectedCategory === $category ? 'bg-primary text-on-primary' : 'border border-outline-variant text-on-surface hover:bg-surface-container-high transition-colors' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
                <div class="flex overflow-x-auto pb-2 gap-2 hide-scrollbar">
                    @foreach (['SEN' => 'Senin', 'SEL' => 'Selasa', 'RAB' => 'Rabu', 'KAM' => 'Kamis', 'JUM' => 'Jumat', 'SAB' => 'Sabtu', 'MIN' => 'Minggu'] as $dayValue => $dayLabel)
                        <a href="{{ request()->fullUrlWithQuery(['category' => $selectedCategory, 'day' => $dayValue]) }}"
                            class="press-anim flex-shrink-0 px-5 py-2 rounded-lg font-label-md text-label-md {{ $selectedDay === $dayValue ? 'bg-surface-container-low border border-primary text-primary' : 'bg-surface-container-lowest border border-outline-variant text-on-surface-variant hover:bg-surface-container-high' }}">
                            {{ $dayLabel }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse ($menus as $index => $menu)
                    <article class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden lift-hover flex flex-col">
                        <div class="aspect-square w-full relative">
                            @if ($menu->image_url)
                                <img alt="{{ $menu->name }}" class="object-cover w-full h-full" src="{{ $menu->image_url }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-surface-container-high">
                                    <span class="material-symbols-outlined text-5xl text-on-surface-variant">restaurant</span>
                                </div>
                            @endif
                            <div class="absolute top-3 left-3 bg-surface-container-lowest/90 backdrop-blur text-primary px-3 py-1 rounded font-label-md text-label-md text-xs uppercase tracking-wider">
                                {{ $menu->category }}
                            </div>
                            <div class="absolute top-3 right-3">
                                @include('partials.menu-like', ['menu' => $menu, 'likedIds' => $likedIds])
                            </div>
                        </div>
                        <div class="p-5 flex flex-col flex-grow gap-3">
                            <div>
                                <h2 class="font-headline-md text-headline-md text-on-surface mb-1">{{ $menu->name }}</h2>
                                <div class="flex items-center gap-2">
                                    @include('partials.avatar', ['user' => $menu->seller, 'size' => 'w-8 h-8'])
                                    <div class="min-w-0">
                                        <p class="font-body-md text-body-md text-on-surface-variant truncate">{{ $menu->seller->nama_lapak ?: $menu->seller->name }}</p>
                                        <p class="font-caption text-caption text-on-surface-variant inline-flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $menu->seller->lapak_buka ? 'bg-secondary' : 'bg-error' }}"></span>
                                            {{ $menu->seller->lapak_buka ? 'Lapak Buka' : 'Lapak Tutup' }}
                                        </p>
                                    </div>
                                </div>
                                <p class="font-caption text-caption text-on-surface-variant mt-1 inline-flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs text-rose-400" style="font-variation-settings: 'FILL' 1;">favorite</span>
                                    {{ (int) $menu->likes_count }} suka warga
                                    @if ($sort === 'populer' && $index < 3 && $menu->likes_count > 0)
                                        <span class="text-primary font-semibold">&middot; masuk rekomendasi</span>
                                    @endif
                                </p>
                            </div>
                            @if ($menu->description)
                                <p class="font-caption text-caption text-on-surface-variant line-clamp-2">{{ $menu->description }}</p>
                            @endif
                            <div class="flex items-center gap-2 mt-2">
                                <span class="px-2 py-0.5 rounded bg-{{ $menu->available ? 'secondary-container text-on-secondary-container' : 'surface-dim text-on-surface-variant' }} font-caption text-caption">{{ $menu->available ? 'Stok Tersedia' : 'Habis' }}</span>
                                <span class="font-caption text-caption text-on-surface-variant">Sisa {{ $menu->stock }} porsi</span>
                            </div>
                            <div class="mt-auto pt-4 flex justify-between items-center border-t border-surface-variant">
                                <span class="font-headline-md text-headline-md text-primary">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                                @php
                                    $waUrl = $menu->seller->whatsappUrl('Halo, saya ingin memesan '.$menu->name.' dari '.$menu->seller->name.' di DapurWarga.');
                                @endphp
                                <a href="{{ $waUrl }}" target="_blank" class="press-anim flex items-center gap-1 bg-secondary text-on-secondary px-4 py-2 rounded font-label-md text-label-md hover:opacity-90 transition-opacity">
                                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">chat</span>
                                    Pesan
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="md:col-span-2 border border-dashed border-outline-variant rounded-xl flex flex-col items-center justify-center p-12 text-center min-h-[280px] bg-surface-container-low/50">
                        <span class="material-symbols-outlined text-5xl text-on-surface-variant mb-4">restaurant</span>
                        <h3 class="font-headline-md text-headline-md text-on-surface mb-2">Belum ada menu terdaftar</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant mb-6">Menu kuliner dari tetangga akan tampil di sini begitu penjual membuka lapaknya.</p>
                        <a href="{{ route('register') }}" class="press-anim px-6 py-2 bg-primary text-on-primary rounded font-label-md text-label-md hover:bg-primary-container transition-colors">Buka Lapak Sekarang</a>
                    </div>
                @endforelse

                @if ($menus->isNotEmpty())
                    <div class="border border-dashed border-outline-variant rounded-xl flex flex-col items-center justify-center p-8 text-center min-h-[350px] bg-surface-container-low/50">
                        <span class="material-symbols-outlined text-4xl text-on-surface-variant mb-4">restaurant</span>
                        <h3 class="font-headline-md text-headline-md text-on-surface mb-2">Masih lapar?</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant mb-6">Lihat jadwal menu untuk hari-hari berikutnya.</p>
                        <button class="press-anim px-6 py-2 border border-outline-variant rounded text-on-surface font-label-md text-label-md hover:bg-surface-container-high transition-colors">Muat Lebih Banyak</button>
                    </div>
                @endif
            </div>
        </div>

        <aside class="lg:col-span-4 flex flex-col gap-8">
            <div class="bg-primary text-on-primary rounded-xl p-6 flex flex-col gap-4">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">help_center</span>
                    <h3 class="font-headline-md text-headline-md">Cara Pesan</h3>
                </div>
                <ol class="flex flex-col gap-3 font-body-md text-body-md">
                    <li class="flex gap-3">
                        <span class="font-bold text-inverse-primary">1.</span>
                        <span>Pilih menu dari jadwal harian. Perhatikan status pesan di muka atau stok tersedia.</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="font-bold text-inverse-primary">2.</span>
                        <span>Klik tombol "Pesan" untuk langsung terhubung ke WhatsApp penjual (tetangga kita).</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="font-bold text-inverse-primary">3.</span>
                        <span>Sepakati metode pembayaran dan waktu pengambilan/pengantaran.</span>
                    </li>
                </ol>
            </div>

            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6">
                <h3 class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-4 border-b border-outline-variant pb-2">Lapak Terpopuler Minggu Ini</h3>
                <ul class="flex flex-col">
                    @forelse (($topSellers ?? collect()) as $index => $seller)
                        <li class="py-3 border-b border-outline-variant border-dashed last:border-0 flex justify-between items-center">
                            <div>
                                <p class="font-label-md text-label-md text-on-surface">{{ $seller->nama_lapak ?: $seller->name }}</p>
                                <p class="font-caption text-caption text-on-surface-variant">{{ number_format((int) ($seller->likes_total ?? 0), 0, ',', '.') }} suka &middot; {{ $seller->menus_count }} menu aktif</p>
                            </div>
                            <span class="material-symbols-outlined text-primary">chevron_right</span>
                        </li>
                    @empty
                        <li class="py-3 text-center">
                            <p class="font-caption text-caption text-on-surface-variant">Belum ada lapak terdaftar.</p>
                        </li>
                    @endforelse
                </ul>
            </div>

            <div class="border border-outline-variant rounded-xl p-6 bg-surface-container-lowest flex flex-col items-center text-center gap-4">
                <span class="material-symbols-outlined text-3xl text-primary">campaign</span>
                <h3 class="font-headline-md text-headline-md text-on-surface">Punya Usaha Kuliner?</h3>
                <p class="font-body-md text-body-md text-on-surface-variant">Daftarkan jualan Anda ke DapurWarga agar mudah ditemukan oleh tetangga sekitar.</p>
                <a href="{{ route('register') }}" class="press-anim mt-2 px-6 py-2 bg-primary text-on-primary rounded font-label-md text-label-md w-full hover:bg-primary-container transition-colors">Daftar Sekarang</a>
            </div>
        </aside>
    </div>
@endsection