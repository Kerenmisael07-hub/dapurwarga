@extends('layouts.app')

@section('title', 'Jasa Warga - DapurWarga')

@section('content')
    <div class="py-section-gap">
        <!-- Header + Carian & Kategori (Flexbox) -->
        <section class="mb-section-gap">
            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-stack-lg">
                <!-- Kiri: Tajuk Utama -->
                <div class="max-w-2xl">
                    <span class="inline-block bg-secondary-container text-on-secondary-container text-caption font-caption px-3 py-1 rounded-full mb-stack-md uppercase tracking-wider font-bold">JASA WARGA</span>
                    <h1 class="text-headline-lg-mobile md:text-headline-lg font-headline-lg-mobile md:font-headline-lg text-primary mb-stack-sm">Pusat Layanan &amp; Keahlian Tetangga</h1>
                    <p class="text-body-lg font-body-lg text-on-surface-variant">Temukan jasa terpercaya dari warga sekitar untuk kebutuhan harian Anda.</p>
                </div>

                <!-- Kanan: Kotak Carian + Senarai Butang Kategori -->
                <div class="w-full lg:w-[420px] lg:shrink-0 flex flex-col gap-3 lg:items-end">
                    <!-- Search -->
                    <form method="GET" action="{{ route('layanan') }}" class="w-full">
                        <input type="hidden" name="category" value="{{ $selectedCategory }}">
                        <div class="relative">
                            <svg class="w-5 h-5 text-on-surface-variant absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input
                                type="text"
                                name="search"
                                value="{{ $search }}"
                                placeholder="Cari jasa atau keahlian..."
                                class="w-full rounded-full border border-outline-variant bg-surface-container-lowest pl-12 pr-4 py-3 text-body-md font-body-md text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary"
                            >
                        </div>
                    </form>

                    <!-- Filter Pills -->
                    <div class="w-full overflow-x-auto pb-1 hide-scrollbar lg:flex lg:justify-end">
                        <div class="flex gap-3 min-w-max">
                            <a href="{{ route('layanan', array_filter(['search' => $search])) }}"
                               class="px-5 py-2 rounded-full text-label-md font-label-md transition-all {{ ! $selectedCategory ? 'bg-primary text-on-primary' : 'bg-surface-container-low text-on-surface-variant hover:bg-surface-container border border-outline-variant' }}">
                                Semua Jasa
                            </a>
                            @foreach ($categories as $category)
                                <a href="{{ route('layanan', array_filter(['category' => $category, 'search' => $search])) }}"
                                   class="px-5 py-2 rounded-full text-label-md font-label-md transition-all {{ $selectedCategory === $category ? 'bg-primary text-on-primary' : 'bg-surface-container-low text-on-surface-variant hover:bg-surface-container border border-outline-variant' }}">
                                    {{ $category }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Service Grid -->
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($services as $service)
                @php
                    $seller = $service->seller;
                    $waMessage = 'Halo '.($seller->name ?? 'Penyedia Jasa').', saya ingin memesan jasa "'.$service->name.'" melalui DapurWarga. Apakah layanan ini tersedia?';
                    $waUrl = $service->whatsappUrl($waMessage);
                @endphp
                <div class="bg-surface-container-lowest border border-outline-variant rounded-lg shadow-sm hover:shadow-md transition-shadow flex flex-col h-full">
                    <div class="p-4 flex flex-col flex-grow">
                        <div class="flex items-center justify-between gap-2 mb-3">
                            @include('layanan.partials.category-badge', ['category' => $service->category])
                            <span class="bg-[#0F5132] text-white text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full shrink-0">Tersedia</span>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="min-w-0 flex-1">
                                <h3 class="text-[17px] leading-6 font-bold text-primary line-clamp-2">{{ $service->name }}</h3>
                                <p class="text-caption font-caption text-on-surface-variant mt-0.5 line-clamp-2">{{ $service->description ?: 'Penyedia jasa ini belum menambahkan deskripsi layanan.' }}</p>
                                <p class="text-label-md font-label-md font-bold text-primary mt-1.5">
                                    @if ($service->price > 0)
                                        {{ $service->formatted_price }} <span class="font-normal text-on-surface-variant">/ {{ $service->price_unit }}</span>
                                    @else
                                        <span class="text-on-surface-variant">Tarif Negosiasi</span>
                                    @endif
                                </p>
                            </div>
                            <div class="shrink-0 w-20 h-20 rounded-lg overflow-hidden bg-surface-container border border-outline-variant flex items-center justify-center">
                                @if ($service->foto)
                                    <img src="{{ asset($service->foto) }}" alt="Foto {{ $service->name }}" class="w-full h-full object-cover">
                                @else
                                    <span class="material-symbols-outlined text-2xl text-on-surface-variant">handyman</span>
                                @endif
                            </div>
                        </div>

                        <div class="border-t border-outline-variant mt-3"></div>

                        <div class="flex items-center gap-2 mt-2.5">
                            @if ($seller?->foto_profile)
                                <img src="{{ $seller->foto_profile }}" alt="{{ $seller->name }}" class="w-7 h-7 rounded-full object-cover shrink-0">
                            @else
                                <div class="w-7 h-7 rounded-full bg-tertiary-container flex items-center justify-center text-on-tertiary-container text-[11px] font-bold shrink-0">
                                    {{ $seller?->initials ?? '?' }}
                                </div>
                            @endif
                            <div class="min-w-0">
                                <p class="text-[13px] leading-4 font-semibold text-on-surface truncate">{{ $seller->name ?? 'Penyedia Jasa' }}</p>
                                <p class="text-[11px] leading-4 text-on-surface-variant">Penyedia Jasa</p>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 pb-4 pt-2.5">
                        <a href="{{ $waUrl }}" target="_blank" rel="noopener"
                           class="w-full bg-[#0F5132] text-white rounded-lg py-2.5 px-4 font-label-md text-label-md font-bold flex items-center justify-center gap-2 hover:bg-[#0c4028] transition-colors">
                            <span class="material-symbols-outlined text-[18px]">chat</span>
                            Hubungi via WhatsApp
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full rounded-2xl border border-dashed border-outline-variant bg-surface-container-lowest p-12 text-center">
                    <span class="material-symbols-outlined text-5xl text-on-surface-variant">search_off</span>
                    <h3 class="text-headline-md font-headline-md text-primary mt-3 mb-1">Belum ada layanan ditemukan</h3>
                    <p class="text-body-md font-body-md text-on-surface-variant">Coba ubah kata kunci pencarian atau pilih kategori lain.</p>
                </div>
            @endforelse
        </section>
    </div>

    <!-- Footer -->
    <footer class="bg-surface-container-low dark:bg-tertiary-container w-full py-stack-lg px-gutter flex flex-col md:flex-row justify-between items-center max-w-container-max mx-auto border-t border-outline-variant dark:border-on-surface-variant mt-auto">
        <div class="text-headline-md font-headline-md font-bold text-primary dark:text-primary-fixed mb-4 md:mb-0">
            DapurWarga
        </div>
        <div class="flex flex-wrap justify-center md:justify-end gap-x-6 gap-y-2 text-caption font-caption">
            <a class="text-on-surface-variant dark:text-on-tertiary-container hover:underline decoration-secondary dark:decoration-secondary-fixed opacity-80 hover:opacity-100 transition-opacity" href="#">Community Guidelines</a>
            <a class="text-on-surface-variant dark:text-on-tertiary-container hover:underline decoration-secondary dark:decoration-secondary-fixed opacity-80 hover:opacity-100 transition-opacity" href="#">RT Portal</a>
            <a class="text-on-surface-variant dark:text-on-tertiary-container hover:underline decoration-secondary dark:decoration-secondary-fixed opacity-80 hover:opacity-100 transition-opacity" href="#">WhatsApp Support</a>
            <a class="text-on-surface-variant dark:text-on-tertiary-container hover:underline decoration-secondary dark:decoration-secondary-fixed opacity-80 hover:opacity-100 transition-opacity" href="#">Contact Us</a>
        </div>
        <div class="text-on-surface dark:text-on-tertiary-container text-caption font-caption mt-4 md:mt-0 opacity-80 hover:opacity-100 transition-opacity text-center md:text-right w-full md:w-auto">
            © 2024 DapurWarga. Professional Community Journalism.
        </div>
    </footer>
@endsection
