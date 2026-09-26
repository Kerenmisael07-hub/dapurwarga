@extends('layouts.app')

@section('title', 'Info RT - DapurWarga')

@section('content')
    <div class="py-section-gap grid grid-cols-1 md:grid-cols-12 gap-gutter">
        <!-- Main Content Area -->
        <div class="md:col-span-8 flex flex-col gap-section-gap">
            <!-- Header Section -->
            <header class="flex flex-col gap-stack-sm border-b border-outline-variant pb-stack-lg">
                <h1 class="font-display-lg text-display-lg text-primary">Pusat Informasi Warga</h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant">Update terkini dan informasi penting untuk warga RT 04 / RW 08. Bersama membangun lingkungan yang nyaman dan kulinari yang sejahtera.</p>
                <div class="inline-flex items-center gap-2 mt-2">
                    <span class="bg-secondary-fixed text-on-secondary-fixed font-label-md text-label-md px-3 py-1 rounded-full">Status: Aktif &amp; Kondusif</span>
                </div>
            </header>

            <!-- Pengumuman Penting (Bento Style) -->
            <section class="flex flex-col gap-stack-md">
                <div class="flex items-center justify-between">
                    <h2 class="font-headline-lg text-headline-lg text-primary">Pengumuman Penting</h2>
                    <a class="font-label-md text-label-md text-primary hover:underline flex items-center gap-1" href="#">Lihat Semua <span class="material-symbols-outlined text-sm" data-icon="arrow_forward">arrow_forward</span></a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">
                    <!-- Urgent Announcement -->
                    <article class="bg-surface-container-lowest border border-outline-variant rounded-xl p-stack-lg flex flex-col gap-stack-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                        <div class="absolute top-0 left-0 w-1 h-full bg-error"></div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="bg-error text-on-error font-caption text-caption px-2 py-0.5 rounded">Segera</span>
                            <span class="font-caption text-caption text-on-surface-variant">12 Okt 2024</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md text-primary group-hover:text-tertiary transition-colors">Kerja Bakti Persiapan Musim Hujan</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant flex-grow">Diharapkan kehadiran seluruh warga untuk membersihkan saluran air dan fasilitas umum RT 04 mulai pukul 07:00 WIB.</p>
                        <a class="font-label-md text-label-md text-primary mt-auto flex items-center gap-1 pt-2" href="#">Baca Selengkapnya <span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span></a>
                    </article>
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
                    <!-- Contact Card 1 -->
                    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-stack-md flex flex-col items-center text-center gap-2 hover:-translate-y-1 transition-transform">
                        <div class="w-12 h-12 rounded-full bg-surface-container-high flex items-center justify-center mb-1">
                            <span class="material-symbols-outlined text-primary" data-icon="person">person</span>
                        </div>
                        <h4 class="font-label-md text-label-md text-primary">Bpk. Haryono</h4>
                        <p class="font-caption text-caption text-on-surface-variant">Ketua RT 04</p>
                        <button class="mt-2 w-full bg-surface-container text-on-surface hover:bg-surface-container-high transition-colors font-caption text-caption py-1.5 rounded flex items-center justify-center gap-1">
                            <span class="material-symbols-outlined text-sm" data-icon="call">call</span> Hubungi
                        </button>
                    </div>
                    <!-- Contact Card 2 -->
                    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-stack-md flex flex-col items-center text-center gap-2 hover:-translate-y-1 transition-transform">
                        <div class="w-12 h-12 rounded-full bg-surface-container-high flex items-center justify-center mb-1">
                            <span class="material-symbols-outlined text-primary" data-icon="security">security</span>
                        </div>
                        <h4 class="font-label-md text-label-md text-primary">Pos Satpam</h4>
                        <p class="font-caption text-caption text-on-surface-variant">Keamanan 24 Jam</p>
                        <button class="mt-2 w-full bg-surface-container text-on-surface hover:bg-surface-container-high transition-colors font-caption text-caption py-1.5 rounded flex items-center justify-center gap-1">
                            <span class="material-symbols-outlined text-sm" data-icon="call">call</span> Hubungi
                        </button>
                    </div>
                    <!-- Contact Card 3 -->
                    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-stack-md flex flex-col items-center text-center gap-2 hover:-translate-y-1 transition-transform">
                        <div class="w-12 h-12 rounded-full bg-surface-container-high flex items-center justify-center mb-1">
                            <span class="material-symbols-outlined text-primary" data-icon="delete">delete</span>
                        </div>
                        <h4 class="font-label-md text-label-md text-primary">Bpk. Slamet</h4>
                        <p class="font-caption text-caption text-on-surface-variant">Pengelola Sampah</p>
                        <button class="mt-2 w-full bg-surface-container text-on-surface hover:bg-surface-container-high transition-colors font-caption text-caption py-1.5 rounded flex items-center justify-center gap-1">
                            <span class="material-symbols-outlined text-sm" data-icon="call">call</span> Hubungi
                        </button>
                    </div>
                </div>
            </section>

            <!-- Galeri Kegiatan -->
            <section class="flex flex-col gap-stack-md">
                <h2 class="font-headline-lg text-headline-lg text-primary">Galeri Kegiatan</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-stack-sm">
                    <div class="aspect-square rounded-xl overflow-hidden bg-surface-container-high">
                        <img class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" data-alt="A bright, high-quality photograph of a community food gathering in a minimalist, modern neighborhood setting. Neighbors are smiling, sharing traditional dishes on clean wooden tables. Soft, natural daylight illuminates the scene, emphasizing a sense of warmth, trust, and clean magazine-style aesthetics." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCP41h2w-qKa_VTP2kzliY4Fdon82yBpc4Lqe1GlbJSYTxRQKPtjusY3aJxosci9s7qOrfAAJBcu4oDCZe2CxH3nOkWl_2Rzh0hc2yTeZMR92fU_pnjJZoeIfTCsG7716lsdPTxk1nFVV7wmHigVYOKU0KizdH62c2783MCW7kczRza0S9MRKlQMj33oLb0sn9JwU7enJVgkBbugt-9IzR4Tet_6sdYBlNJq95--TMmkLI1uB276j7JHA"/>
                    </div>
                    <div class="aspect-square rounded-xl overflow-hidden bg-surface-container-high">
                        <img class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" data-alt="A crisp, professional photo of a neighborhood meeting. Residents sit in a well-lit, minimalist community hall with clean white walls and subtle indigo accents. The focus is on a speaker at the front. The lighting is bright and even, capturing a mood of organized, credible local governance." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBShn0OJfmUNjwBBFl_bEuvxAePt0DqjEF4gWeCQsPzWg7VL6CLsnVk3CFN4v1gdbA4vbvxvDwXUBia154t8idlfKsIbD3dRG05hVpl1z2LzasjT9WhUqK7W2op5kUqtosGkiGjEIopmO2JTmGyjLbUqtWXbMxtkksg8c-fb8NC1IZwKsw6peZF3Shjgox5MtdZlmRDnzO77CcHpkwSLQg9YQ9Atgg7qyRXkn8HfWjp3NEFaWffioaxeA"/>
                    </div>
                    <div class="aspect-square rounded-xl overflow-hidden bg-surface-container-high hidden md:block">
                        <img class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" data-alt="A close-up, magazine-quality shot of a bustling local food stall during a community event. Clean stainless steel counters, vibrant fresh ingredients, and a vendor smiling. The lighting is natural and bright, highlighting the appetizing food and the clean, hygienic environment consistent with a trusted local portal." src="https://lh3.googleusercontent.com/aida-public/AB6AXuASWKA2zMSHwXJ2T97Kxs9KNsFwRtz5KTsMxn8U8TEBqMajA5uEinj2TlSpBGb-rvVlnNpqGM-hEi5hQ8zzRVxdDZsIwt64VybRIhI-0cf0cRQKJ6vcIB__01D1kTv0e5trPmbtqd5SK_AW81g0hnaOb_BszjNQfrCzPVOo83I_2qo28ujlB9qjnqNWo5zxmkRNk_khmUxm5PCjdQ6IsUtm46ch3R2ergKWf05NC96yglPig6ilv44CQA"/>
                    </div>
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
                            <span class="font-label-md text-label-md text-primary">24</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-outline-variant/50">
                            <span class="font-body-md text-body-md text-on-surface-variant flex items-center gap-2"><span class="material-symbols-outlined text-primary text-sm" data-icon="groups">groups</span> Total Warga</span>
                            <span class="font-label-md text-label-md text-primary">156 KK</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="font-body-md text-body-md text-on-surface-variant flex items-center gap-2"><span class="material-symbols-outlined text-primary text-sm" data-icon="event_available">event_available</span> Kegiatan Bulan Ini</span>
                            <span class="font-label-md text-label-md text-primary">3</span>
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