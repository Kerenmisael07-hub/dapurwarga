@extends('layouts.app')

@section('title', 'DapurWarga - Kuliner Lokal & UMKM Warga')

@section('content')
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        .faq-item > summary { list-style: none; }
        .faq-item > summary::-webkit-details-marker { display: none; }
        .faq-item > summary::marker { content: ""; }
        .faq-chevron { transition: transform 0.2s ease; }
        .faq-item[open] .faq-chevron { transform: rotate(180deg); }
    </style>

    <!-- Main Container x-data Alpine.js -->
        <div x-data="{ 
            selectedCategory: 'all'
         }" 
         class="flex flex-col gap-10 py-6 text-slate-800">

        <!-- ================= 1. HERO SECTION ================= -->
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center border border-slate-200 rounded-2xl bg-slate-50 px-6 py-8 md:px-10 md:py-10">
            <div class="lg:col-span-7 flex flex-col gap-5">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-amber-900">
                        <span class="material-symbols-outlined text-sm">local_fire_department</span>
                        Katalog Kuliner Warga
                    </span>
                    <span class="text-xs font-medium text-slate-500">& UMKM lokal</span>
                </div>

                <h1 class="max-w-2xl text-4xl sm:text-5xl font-bold text-slate-950 leading-[1.08] tracking-tight">
                    Kuliner Buatan Tetangga, Diantar Langsung.
                </h1>

                <p class="text-base text-slate-600 leading-relaxed max-w-xl">
                    Pesan makanan dan jajanan dari warga sekitar. Atur pengantaran atau ambil sendiri sesuai kesepakatan dengan penjual, tanpa komisi.
                </p>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="#jadwal-kuliner" class="inline-flex items-center gap-2 rounded-lg bg-slate-950 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                        Lihat menu hari ini
                        <span class="material-symbols-outlined text-base">arrow_downward</span>
                    </a>
                    <a href="{{ route('jadwal-kuliner') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-800 transition hover:border-slate-950">
                        Jadwal kuliner
                        <span class="material-symbols-outlined text-base">calendar_month</span>
                    </a>
                </div>

                <div class="flex flex-wrap items-center gap-x-6 gap-y-2 border-t border-slate-200 pt-4 text-xs text-slate-500">
                    <span class="inline-flex items-center gap-1.5"><span class="material-symbols-outlined text-base text-emerald-600">verified</span>Tanpa komisi</span>
                    <span class="inline-flex items-center gap-1.5"><span class="material-symbols-outlined text-base text-emerald-600">chat</span>Pesan langsung via WhatsApp</span>
                </div>

            </div>

            <div class="lg:col-span-5 flex justify-center">
                @if ($featuredMenu)
                    <div class="w-full max-w-sm border border-slate-200 rounded-xl overflow-hidden bg-white shadow-sm">
                        <div class="relative">
                            @if ($featuredMenu->image_url)
                                <img src="{{ $featuredMenu->image_url }}" alt="{{ $featuredMenu->name }}" class="w-full aspect-square object-cover">
                            @else
                                <div class="w-full aspect-square flex items-center justify-center text-slate-400 bg-slate-100">
                                    <span class="material-symbols-outlined text-4xl">restaurant</span>
                                </div>
                            @endif

                            <span class="absolute top-3 left-3 bg-rose-500 text-white font-semibold text-[10px] px-2 py-1 rounded inline-flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs" style="font-variation-settings: 'FILL' 1;">favorite</span>
                                Rekomendasi
                            </span>
                        </div>
                        <div class="p-4 border-t border-slate-100 flex items-center justify-between gap-3">
                            <div class="min-w-0">
                                <h3 class="font-bold text-base text-slate-900 truncate">{{ $featuredMenu->name }}</h3>
                                <p class="text-xs text-slate-500 mt-1">
                                    Tersedia {{ $featuredMenu->days ? implode(', ', $featuredMenu->days) : 'setiap hari' }}
                                </p>
                            </div>
                            @include('partials.menu-like', ['menu' => $featuredMenu, 'likedIds' => $likedIds])
                        </div>
                    </div>
                @else
                    <div class="w-full max-w-sm border border-slate-200 rounded-xl overflow-hidden bg-white shadow-sm">
                        <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=800&q=80" alt="Dapur Warga Kuliner" class="w-full aspect-square object-cover">
                        <div class="p-4 border-t border-slate-100">
                            <span class="text-[11px] font-medium text-slate-500 uppercase tracking-wider">Rekomendasi</span>
                            <h3 class="font-bold text-base text-slate-900 mt-0.5">Ayam Bakar Madu Pak RT</h3>
                            <p class="text-xs text-slate-500 mt-1">Tersedia setiap hari Jumat & Sabtu</p>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <!-- ================= 2. CARA PESAN ================= -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-4 border-b border-slate-200 pb-8">
            <div class="p-4 border border-slate-200 rounded-lg bg-white flex items-start gap-3">
                <span class="font-bold text-sm text-slate-400">01</span>
                <div>
                    <h4 class="font-semibold text-sm text-slate-900">Pilih Menu</h4>
                    <p class="text-xs text-slate-500 mt-0.5">Temukan sajian sesuai selera Anda.</p>
                </div>
            </div>
            <div class="p-4 border border-slate-200 rounded-lg bg-white flex items-start gap-3">
                <span class="font-bold text-sm text-slate-400">02</span>
                <div>
                    <h4 class="font-semibold text-sm text-slate-900">Hubungi Penjual</h4>
                    <p class="text-xs text-slate-500 mt-0.5">Pesan langsung melalui WhatsApp.</p>
                </div>
            </div>
            <div class="p-4 border border-slate-200 rounded-lg bg-white flex items-start gap-3">
                <span class="font-bold text-sm text-slate-400">03</span>
                <div>
                    <h4 class="font-semibold text-sm text-slate-900">Antar atau Ambil</h4>
                    <p class="text-xs text-slate-500 mt-0.5">Pilih diantar atau ambil sendiri, lalu bayar langsung.</p>
                </div>
            </div>
        </section>

        <!-- ================= 3. PALING DISUKAI ================= -->
        <section class="flex flex-col gap-4">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">Paling Disukai Warga</h2>
                    <p class="text-xs text-slate-500 mt-1">
                        Menu dengan suka terbanyak dari warga. Makin banyak suka, makin tinggi di rekomendasi.
                    </p>
                </div>
                <span class="text-[11px] font-medium text-slate-500 bg-slate-100 rounded-full px-3 py-1 shrink-0">
                    {{ number_format($totalLikes, 0, ',', '.') }} suka terkumpul
                </span>
            </div>

            @if ($topMenus->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($topMenus as $rank => $topMenu)
                        @php
                            $topSellerName = $topMenu->seller->nama_lapak ?: ($topMenu->seller->name ?? 'Warga');
                        @endphp
                        <div class="bg-white border border-slate-200 rounded-lg p-3 flex items-center gap-3">
                            <div class="w-14 h-14 rounded bg-slate-100 border border-slate-200 overflow-hidden shrink-0">
                                @if ($topMenu->image_url)
                                    <img src="{{ $topMenu->image_url }}" alt="{{ $topMenu->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-400">
                                        <span class="material-symbols-outlined">restaurant</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex flex-col gap-1 min-w-0 flex-grow">
                                <div class="flex items-center gap-1.5 min-w-0">
                                    <span class="text-[10px] font-bold text-slate-400 shrink-0">#{{ $rank + 1 }}</span>
                                    <h3 class="text-xs font-bold text-slate-900 truncate">{{ $topMenu->name }}</h3>
                                </div>
                                <p class="text-[11px] text-slate-500 truncate">{{ $topSellerName }}</p>
                            </div>
                            @include('partials.menu-like', ['menu' => $topMenu, 'likedIds' => $likedIds])
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white border border-dashed border-slate-300 rounded-lg p-6 text-center">
                    <span class="material-symbols-outlined text-3xl text-slate-300">favorite</span>
                    <p class="text-sm font-medium text-slate-600 mt-2">Belum ada menu yang disukai warga.</p>
                    <p class="text-xs text-slate-500 mt-1">Tekan ikon hati pada menu di bawah untuk masuk ke rekomendasi.</p>
                </div>
            @endif
        </section>

        <!-- ================= 4. FILTER TABS ================= -->
        <section class="flex flex-col gap-4">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-bold text-slate-900">Daftar Menu</h2>
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-1 bg-slate-100 rounded-md p-0.5">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'populer']) }}"
                           class="px-3 py-1.5 rounded text-xs font-medium transition-all {{ $sort === 'populer' ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-200' }}">
                            Paling Disukai
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'terbaru']) }}"
                           class="px-3 py-1.5 rounded text-xs font-medium transition-all {{ $sort === 'terbaru' ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-200' }}">
                            Terbaru
                        </a>
                    </div>
                        <button @click="selectedCategory = 'all'" 
                            x-show="selectedCategory !== 'all'"
                            class="text-xs text-slate-500 hover:text-slate-900 underline">
                        Reset Filter
                    </button>
                </div>
            </div>

            <!-- Simple Category Buttons -->
            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-1">
                <button @click="selectedCategory = 'all'" 
                        :class="selectedCategory === 'all' ? 'bg-slate-900 text-white font-medium' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" 
                        class="px-4 py-2 rounded-md text-xs transition-all whitespace-nowrap">
                    Semua
                </button>
                <button @click="selectedCategory = 'Makanan Heavy'" 
                        :class="selectedCategory === 'Makanan Heavy' ? 'bg-slate-900 text-white font-medium' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" 
                        class="px-4 py-2 rounded-md text-xs transition-all whitespace-nowrap">
                    Makanan Berat
                </button>
                <button @click="selectedCategory = 'Camilan'" 
                        :class="selectedCategory === 'Camilan' ? 'bg-slate-900 text-white font-medium' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" 
                        class="px-4 py-2 rounded-md text-xs transition-all whitespace-nowrap">
                    Camilan
                </button>
                <button @click="selectedCategory = 'Minuman'" 
                        :class="selectedCategory === 'Minuman' ? 'bg-slate-900 text-white font-medium' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" 
                        class="px-4 py-2 rounded-md text-xs transition-all whitespace-nowrap">
                    Minuman
                </button>
            </div>
        </section>

        <!-- ================= 5. MAIN CONTENT GRID ================= -->
        <section id="jadwal-kuliner" class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- LEFT COLUMN: CARDS GRID (8 Cols) -->
            <div class="lg:col-span-8 flex flex-col gap-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse ($menus as $index => $menu)
                        @php
                            $sellerName = $menu->seller->name ?? 'Warga';
                            $wa = $menu->seller->no_wa ? preg_replace('/[^0-9]/', '', $menu->seller->no_wa) : '';
                            $waUrl = 'https://wa.me/' . $wa . '?text=' . rawurlencode('Halo, saya ingin memesan ' . $menu->name . ' dari ' . $sellerName . ' via DapurWarga.');
                        @endphp

                        <!-- SIMPLE CARD -->
                        <article 
                            x-show="selectedCategory === 'all' || '{{ $menu->category }}'.includes(selectedCategory)"
                            class="bg-white border border-slate-200 rounded-lg overflow-hidden flex flex-col justify-between">
                            
                            <div>
                                <!-- Image Section -->
                                <div class="relative aspect-square bg-slate-100 border-b border-slate-100">
                                    @if ($menu->image_url)
                                        <img alt="{{ $menu->name }}" class="w-full h-full object-cover" src="{{ $menu->image_url }}">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-400">
                                            <span class="material-symbols-outlined text-4xl">restaurant</span>
                                        </div>
                                    @endif

                                    <span class="absolute top-2 left-2 bg-slate-900/80 text-white font-medium text-[10px] px-2 py-0.5 rounded">
                                        {{ $menu->category }}
                                    </span>

                                    <div class="absolute top-2 right-2 flex flex-col items-end gap-1.5">
                                        @if (in_array((int) $menu->id, $recommendedIds, true))
                                            <span class="bg-amber-400 text-amber-950 font-semibold text-[10px] px-2 py-0.5 rounded inline-flex items-center gap-1">
                                                <span class="material-symbols-outlined text-xs" style="font-variation-settings: 'FILL' 1;">star</span>
                                                Rekomendasi
                                            </span>
                                        @endif
                                        @include('partials.menu-like', ['menu' => $menu, 'likedIds' => $likedIds])
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="p-4">
                                    <div class="flex items-center justify-between gap-2 text-xs text-slate-500 mb-1">
                                        <span>{{ $menu->days ? implode(', ', $menu->days) : 'Setiap Hari' }}</span>
                                        <span class="font-bold text-slate-900 text-sm">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                                    </div>

                                    <h3 class="font-bold text-base text-slate-900 line-clamp-1">
                                        {{ $menu->name }}
                                    </h3>
                                    
                                    <p class="text-xs text-slate-500 mt-1 line-clamp-2">
                                        {{ $menu->description ?? 'Tidak ada deskripsi.' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Card Footer -->
                            <div class="p-4 pt-0 mt-auto">
                                <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                                    <div class="flex items-center gap-2 min-w-0">
                                        @include('partials.avatar', ['user' => $menu->seller, 'size' => 'w-7 h-7', 'ring' => 'border border-slate-200'])
                                        <div class="flex flex-col min-w-0">
                                            <span class="text-xs font-semibold text-slate-800 truncate">
                                                {{ $menu->seller->nama_lapak ?: $sellerName }}
                                            </span>
                                        </div>
                                    </div>

                                    <a href="{{ $waUrl }}" target="_blank" 
                                       class="bg-slate-900 hover:bg-slate-800 text-white font-medium text-xs px-3 py-1.5 rounded transition-all shrink-0">
                                        Pesan WA
                                    </a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="md:col-span-2 bg-slate-50 border border-slate-200 rounded-lg p-8 text-center">
                            <p class="text-sm font-medium text-slate-600">Menu tidak ditemukan.</p>
                            <button @click="selectedCategory = 'all'" class="mt-2 text-xs text-slate-900 underline font-semibold">
                                Tampilkan Semua
                            </button>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- RIGHT COLUMN: SIDEBAR (4 Cols) -->
            <aside class="lg:col-span-4 flex flex-col gap-6">
                
                <!-- Widget 1: Top Lapak -->
                <div class="bg-white border border-slate-200 rounded-lg p-5">
                    <h3 class="font-bold text-xs text-slate-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100">
                        Lapak Terfavorit
                    </h3>

                    <div class="flex flex-col gap-3">
                        @forelse ($topSellers as $rank => $seller)
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-bold text-slate-400 w-4">0{{ $rank + 1 }}</span>
                                @include('partials.avatar', ['user' => $seller, 'size' => 'w-8 h-8', 'ring' => 'border border-slate-200'])
                                <div class="flex-grow min-w-0">
                                    <h4 class="font-semibold text-xs text-slate-900 truncate">{{ $seller->nama_lapak ?: $seller->name }}</h4>
                                    <p class="text-[11px] text-slate-500 inline-flex items-center gap-1">
                                        <span class="material-symbols-outlined text-xs text-rose-400" style="font-variation-settings: 'FILL' 1;">favorite</span>
                                        {{ number_format((int) $seller->likes_total, 0, ',', '.') }} suka
                                        <span class="text-slate-300">|</span>
                                        {{ $seller->menus_count }} menu
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-500">Belum ada data.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Widget 2: Pengumuman Warga -->
                <div class="bg-white border border-slate-200 rounded-lg p-5">
                    <h3 class="font-bold text-xs text-slate-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100">
                        Informasi Komplek
                    </h3>
                    <div class="flex flex-col gap-3">
                        <div>
                            <h4 class="font-semibold text-xs text-slate-900">Bazar Kuliner Akhir Bulan</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Sabtu & Minggu di Lapangan Utama RT 03.</p>
                        </div>
                        <div class="pt-2 border-t border-slate-100">
                            <h4 class="font-semibold text-xs text-slate-900">Pendaftaran Lapak Baru</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Warga yang ingin berjualan dapat mendaftar melalui tombol di bawah.</p>
                        </div>
                    </div>
                </div>

                <!-- Widget 3: Seller CTA -->
                <div class="bg-slate-900 text-white rounded-lg p-5 flex flex-col gap-3">
                    <h3 class="font-bold text-base">Ingin Berjualan?</h3>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Buka lapak kuliner Anda sendiri dan terima pesanan langsung dari warga sekitar.
                    </p>
                    <a href="{{ route('register') }}" class="mt-1 bg-white text-slate-900 font-semibold text-xs py-2 rounded text-center hover:bg-slate-100 transition-all">
                        Daftar Lapak
                    </a>
                </div>

            </aside>
        </section>

        <!-- ================= 6. FAQ SECTION ================= -->
        @php
            $faqs = [
                [
                    'icon' => 'chat',
                    'q' => 'Bagaimana cara memesan makanan?',
                    'a' => 'Klik tombol "Pesan WA" pada menu yang Anda pilih untuk terhubung langsung dengan penjual via WhatsApp.',
                ],
                [
                    'icon' => 'money_off',
                    'q' => 'Apakah ada biaya transaksi perantara?',
                    'a' => 'Tidak ada. Layanan ini gratis dan transaksi dilakukan secara langsung antara pembeli dan penjual.',
                ],
                [
                    'icon' => 'two_wheeler',
                    'q' => 'Apakah DapurWarga menyediakan pengantaran?',
                    'a' => 'Bisa. Pengantaran atau ambil sendiri ditentukan langsung oleh penjual pada halaman lapak. Ongkos kirim dan jam pengantaran diatur lewat kesepakatan di WhatsApp.',
                ],
                [
                    'icon' => 'storefront',
                    'q' => 'Siapa saja yang bisa berjualan di DapurWarga?',
                    'a' => 'Warga atau UMKM lokal. Klik tombol Daftar Lapak di bagian atas halaman ini, isi data lapak, lalu langsung bisa mengunggah menu.',
                ],
                [
                    'icon' => 'calendar_month',
                    'q' => 'Bagaimana cara mengetahui menu tersedia hari ini?',
                    'a' => 'Setiap menu menulis jadwal hari di kartunya. Menu tanpa jadwal khusus tampil sebagai Setiap Hari.',
                ],
                [
                    'icon' => 'category',
                    'q' => 'Kategori apa saja yang tersedia?',
                    'a' => 'Saat ini ada tiga kategori: Makanan Berat, Camilan, dan Minuman. Gunakan tombol filter di atas daftar menu untuk menyaring sesuai kebutuhan.',
                ],
                [
                    'icon' => 'favorite',
                    'q' => 'Apa itu menu Rekomendasi dan menu Paling Disukai?',
                    'a' => 'Menu Rekomendasi adalah yang paling sering dipesan warga. Menu Paling Disukai diurutkan dari jumlah hati yang terkumpul.',
                ],
                [
                    'icon' => 'lock',
                    'q' => 'Apakah saya perlu akun untuk memesan?',
                    'a' => 'Tidak perlu. Untuk memesan cukup chat penjual lewat WhatsApp. Akun baru dibutuhkan bila Anda ingin membuka lapak.',
                ],
                [
                    'icon' => 'payment',
                    'q' => 'Bagaimana cara melakukan pembayaran?',
                    'a' => 'Pembayaran dilakukan langsung kepada penjual lewat metode yang disepakati (transfer, QRIS, atau tunai saat ambil). DapurWarga tidak memproses atau menahan dana.',
                ],
                [
                    'icon' => 'report',
                    'q' => 'Bagaimana jika ada menu yang tidak sesuai?',
                    'a' => 'Sampaikan lewat WhatsApp penjual atau ke admin lewat halaman Info RT agar bisa ditindaklanjuti.',
                ],
                [
                    'icon' => 'hourglass_empty',
                    'q' => 'Apakah stok menu terbatas?',
                    'a' => 'Ya. Stok tiap lapak terbatas, sebab masakannya dibuat sendiri. Konfirmasi stok ke penjual sebelum membayar.',
                ],
                [
                    'icon' => 'verified',
                    'q' => 'Apakah semua penjual di DapurWarga sudah terverifikasi?',
                    'a' => 'Setiap lapak harus melengkapi data diri dan nomor WhatsApp aktif sebelum bisa memasang menu, sehingga Anda tahu siapa yang Anda ajak bertransaksi.',
                ],
            ];
        @endphp

        <section class="bg-white border border-slate-200 rounded-lg p-6 max-w-4xl mx-auto w-full">
            <div class="flex items-center justify-between gap-3 mb-4 pb-2 border-b border-slate-100">
                <h2 class="text-lg font-bold text-slate-900">Pertanyaan Sering Diajukan</h2>
                <span class="shrink-0 text-[10px] font-medium text-slate-500 bg-slate-100 rounded-full px-2.5 py-1">
                    {{ count($faqs) }} pertanyaan
                </span>
            </div>

            <div class="flex flex-col gap-2">
                @foreach ($faqs as $faq)
                    <details class="faq-item group border border-slate-200 rounded-md overflow-hidden bg-white hover:border-slate-300 transition-colors">
                        <summary class="w-full p-3 text-left font-semibold text-xs text-slate-800 flex justify-between items-center gap-3 bg-slate-50 group-hover:bg-slate-100 cursor-pointer select-none transition-colors">
                            <span class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm text-slate-400 shrink-0">{{ $faq['icon'] }}</span>
                                {{ $faq['q'] }}
                            </span>
                            <span class="material-symbols-outlined faq-chevron text-sm text-slate-400 shrink-0">expand_more</span>
                        </summary>
                        <div class="p-3 text-xs text-slate-600 leading-relaxed border-t border-slate-200">
                            {{ $faq['a'] }}
                        </div>
                    </details>
                @endforeach
            </div>
        </section>

    </div>

    <!-- ================= 7. FOOTER ================= -->
    <footer class="bg-slate-100 border-t border-slate-200 full-width mt-10 py-6">
        <div class="max-w-container-max mx-auto px-gutter flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-500">
            <div>
                <span class="font-bold text-slate-900 text-sm block">DapurWarga</span>
                <span>Platform Kuliner Warga & UMKM Lokal.</span>
            </div>
            <p>© {{ date('Y') }} DapurWarga.</p>
        </div>
    </footer>
@endsection