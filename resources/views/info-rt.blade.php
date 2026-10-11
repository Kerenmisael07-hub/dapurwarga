@extends('layouts.app')

@section('title', 'Info RT - DapurWarga')

@section('content')
    @php
        $settings = \App\Models\RtSetting::all()->pluck('value', 'key');
        $announcements = \App\Models\RtAnnouncement::orderByDesc('tanggal')->orderByDesc('id')->limit(3)->get();
        $contacts = \App\Models\RtContact::latest()->limit(6)->get();
        $gallery = \App\Models\RtGallery::latest()->limit(6)->get();
        $statusText = $settings['status_text'] ?? 'Aktif & Kondusif';
        $lapakAktif = $settings['lapak_aktif'] ?? '24';
        $totalWarga = $settings['total_warga'] ?? '156 KK';
        $kegiatanBulanIni = $settings['kegiatan_bulan_ini'] ?? '3';
    @endphp
    <div class="py-section-gap grid grid-cols-1 md:grid-cols-12 gap-gutter">
        <!-- Main Content Area -->
        <div class="md:col-span-8 flex flex-col gap-section-gap">
            <!-- Header Section -->
            <header class="flex flex-col gap-stack-sm border-b border-outline-variant pb-stack-lg">
                <h1 class="font-display-lg text-display-lg text-primary">Pusat Informasi Warga</h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant">Update terkini dan informasi penting untuk warga RT 04 / RW 08. Bersama membangun lingkungan yang nyaman dan kulinari yang sejahtera.</p>
                <div class="inline-flex items-center gap-2 mt-2">
                    <span class="bg-secondary-fixed text-on-secondary-fixed font-label-md text-label-md px-3 py-1 rounded-full">Status: {{ $statusText }}</span>
                </div>
            </header>

            <!-- Pengumuman Penting (Bento Style) -->
            <section class="flex flex-col gap-stack-md">
                <div class="flex items-center justify-between">
                    <h2 class="font-headline-lg text-headline-lg text-primary">Pengumuman Penting</h2>
                    <span class="font-label-md text-label-md text-primary hover:underline flex items-center gap-1">Lihat Semua <span class="material-symbols-outlined text-sm" data-icon="arrow_forward">arrow_forward</span></span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">
                    <!-- Urgent Announcement -->
                    @php $urgent = $announcements->firstWhere('is_urgent', true) ?? $announcements->first(); @endphp
                    @if ($urgent)
                        <article class="bg-surface-container-lowest border border-outline-variant rounded-xl p-stack-lg flex flex-col gap-stack-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                            <div class="absolute top-0 left-0 w-1 h-full {{ $urgent->is_urgent ? 'bg-error' : 'bg-primary' }}"></div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="{{ $urgent->is_urgent ? 'bg-error text-on-error' : 'bg-surface-container-high text-on-surface' }} font-caption text-caption px-2 py-0.5 rounded">{{ $urgent->category ?: ($urgent->is_urgent ? 'Segera' : 'Informasi') }}</span>
                                @if ($urgent->tanggal)
                                    <span class="font-caption text-caption text-on-surface-variant">{{ $urgent->tanggal->format('d M Y') }}</span>
                                @endif
                            </div>
                            <h3 class="font-headline-md text-headline-md text-primary group-hover:text-tertiary transition-colors">{{ $urgent->title }}</h3>
                            <p class="font-body-md text-body-md text-on-surface-variant flex-grow">{{ $urgent->body }}</p>
                            <span class="font-label-md text-label-md text-primary mt-auto flex items-center gap-1 pt-2">Baca Selengkapnya <span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span></span>
                        </article>
                    @endif
                    <!-- Standard Announcements Stack -->
                    <div class="flex flex-col gap-stack-md">
                        @foreach ($announcements->skip(1)->take(2) as $ann)
                            <article class="bg-surface-container-lowest border border-outline-variant rounded-xl p-stack-md flex flex-col gap-1 hover:shadow-sm transition-shadow">
                                <div class="flex items-center gap-2">
                                    <span class="bg-surface-container-high text-on-surface font-caption text-caption px-2 py-0.5 rounded">{{ $ann->category ?: 'Informasi' }}</span>
                                    @if ($ann->tanggal)
                                        <span class="font-caption text-caption text-on-surface-variant">{{ $ann->tanggal->format('d M Y') }}</span>
                                    @endif
                                </div>
                                <h3 class="font-label-md text-label-md text-primary">{{ $ann->title }}</h3>
                                <span class="font-caption text-caption text-primary flex items-center gap-1 mt-1">Detail <span class="material-symbols-outlined text-xs" data-icon="arrow_outward">arrow_outward</span></span>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
                    <!-- Standard Announcements Stack -->
                    <div class="flex flex-col gap-stack-md">
                        <article class="bg-surface-container-lowest border border-outline-variant rounded-xl p-stack-md flex flex-col gap-1 hover:shadow-sm transition-shadow">
                            <div class="flex items-center gap-2">
                                <span class="bg-surface-container-high text-on-surface font-caption text-caption px-2 py-0.5 rounded">Administrasi</span>
                                <span class="font-caption text-caption text-on-surface-variant">10 Okt 2024</span>
                            </div>
                            <h3 class="font-label-md text-label-md text-primary">Iuran Bulanan &amp; Dana Sosial Okotober</h3>
                            <a class="font-caption text-caption text-primary flex items-center gap-1 mt-1" href="#">Detail Pembayaran <span class="material-symbols-outlined text-xs" data-icon="arrow_outward">arrow_outward</span></a>
                        </article>
                        <article class="bg-surface-container-lowest border border-outline-variant rounded-xl p-stack-md flex flex-col gap-1 hover:shadow-sm transition-shadow">
                            <div class="flex items-center gap-2">
                                <span class="bg-surface-container-high text-on-surface font-caption text-caption px-2 py-0.5 rounded">Kesehatan</span>
                                <span class="font-caption text-caption text-on-surface-variant">08 Okt 2024</span>
                            </div>
                            <h3 class="font-label-md text-label-md text-primary">Jadwal Posyandu Balita &amp; Lansia</h3>
                            <a class="font-caption text-caption text-primary flex items-center gap-1 mt-1" href="#">Lihat Jadwal <span class="material-symbols-outlined text-xs" data-icon="arrow_outward">arrow_outward</span></a>
                        </article>
                    </div>
                </div>
            </section>

            <!-- Kontak Penting -->
            <section class="flex flex-col gap-stack-md">
                <h2 class="font-headline-lg text-headline-lg text-primary">Kontak Penting</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-stack-md">
                    @foreach ($contacts as $contact)
                        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-stack-md flex flex-col items-center text-center gap-2 hover:-translate-y-1 transition-transform">
                            <div class="w-12 h-12 rounded-full bg-surface-container-high flex items-center justify-center mb-1">
                                <span class="material-symbols-outlined text-primary" data-icon="{{ $contact->icon ?: 'person' }}">{{ $contact->icon ?: 'person' }}</span>
                            </div>
                            <h4 class="font-label-md text-label-md text-primary">{{ $contact->name }}</h4>
                            <p class="font-caption text-caption text-on-surface-variant">{{ $contact->role }}</p>
                            @if ($contact->phone)
                                <a href="tel:{{ $contact->phone }}" class="mt-2 w-full bg-surface-container text-on-surface hover:bg-surface-container-high transition-colors font-caption text-caption py-1.5 rounded flex items-center justify-center gap-1">
                                    <span class="material-symbols-outlined text-sm" data-icon="call">call</span> Hubungi
                                </a>
                            @else
                                <span class="mt-2 w-full bg-surface-container text-on-surface/50 font-caption text-caption py-1.5 rounded flex items-center justify-center gap-1">
                                    <span class="material-symbols-outlined text-sm" data-icon="call">call</span> Hubungi
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Galeri Kegiatan -->
            <section class="flex flex-col gap-stack-md">
                <h2 class="font-headline-lg text-headline-lg text-primary">Galeri Kegiatan</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-stack-sm">
                    @foreach ($gallery as $item)
                        <div class="aspect-square rounded-xl overflow-hidden bg-surface-container-high">
                            <img class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" src="{{ $item->image }}" alt="Galeri kegiatan RT">
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        <!-- Sidebar (Sticky on Desktop) -->
        <aside class="md:col-span-4 flex flex-col gap-section-gap">
            <div class="sticky top-24 flex flex-col gap-stack-lg">
                <!-- Statistik Lingkungan Widget -->
                <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-stack-lg flex flex-col gap-stack-md">
                    <h3 class="font-headline-md text-headline-md text-primary border-b border-outline-variant pb-2">Statistik Lingkungan</h3>
                    <div class="flex flex-col gap-stack-sm">
                        <div class="flex justify-between items-center py-2 border-b border-outline-variant/50">
                            <span class="font-body-md text-body-md text-on-surface-variant flex items-center gap-2"><span class="material-symbols-outlined text-primary text-sm" data-icon="storefront">storefront</span> Lapak Aktif</span>
                            <span class="font-label-md text-label-md text-primary">{{ $lapakAktif }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-outline-variant/50">
                            <span class="font-body-md text-body-md text-on-surface-variant flex items-center gap-2"><span class="material-symbols-outlined text-primary text-sm" data-icon="groups">groups</span> Total Warga</span>
                            <span class="font-label-md text-label-md text-primary">{{ $totalWarga }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="font-body-md text-body-md text-on-surface-variant flex items-center gap-2"><span class="material-symbols-outlined text-primary text-sm" data-icon="event_available">event_available</span> Kegiatan Bulan Ini</span>
                            <span class="font-label-md text-label-md text-primary">{{ $kegiatanBulanIni }}</span>
                        </div>
                    </div>
                </div>
                <!-- Saran & Masukan Widget -->
                <div class="bg-primary text-on-primary rounded-xl p-stack-lg flex flex-col gap-stack-md relative overflow-hidden">
                    <div class="absolute -right-8 -top-8 opacity-10">
                        <span class="material-symbols-outlined text-[120px]" data-icon="forum">forum</span>
                    </div>
                    <h3 class="font-headline-md text-headline-md relative z-10">Saran &amp; Masukan</h3>
                    <p class="font-body-md text-body-md text-inverse-primary relative z-10 text-sm">Punya ide untuk kemajuan RT atau keluhan terkait fasilitas umum? Sampaikan secara langsung.</p>
                    <a class="mt-2 inline-flex justify-center items-center gap-2 bg-on-primary text-primary font-label-md text-label-md px-4 py-2 rounded-lg hover:bg-surface-container-highest transition-colors relative z-10" href="#">
                        Isi Formulir <span class="material-symbols-outlined text-sm" data-icon="edit_note">edit_note</span>
                    </a>
                </div>
            </div>
        </aside>
    </div>

    <!-- Footer -->
    <footer class="bg-surface-container-lowest text-on-surface border-t border-outline-variant w-full py-stack-lg px-gutter max-w-container-max mx-auto flex flex-col md:flex-row justify-between items-center gap-stack-md mt-auto">
        <div class="font-headline-md text-headline-md font-bold text-primary">DapurWarga</div>
        <div class="flex flex-wrap justify-center gap-x-stack-md gap-y-stack-sm">
            <a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors" href="#">Tentang Kami</a>
            <a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors" href="#">Pedoman Komunitas</a>
            <a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors" href="#">Kontak</a>
            <a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors" href="#">Kebijakan Privasi</a>
        </div>
        <div class="font-caption text-caption text-on-surface-variant">
            © 2024 DapurWarga. Jurnalisme Kuliner Warga.
        </div>
    </footer>
@endsection