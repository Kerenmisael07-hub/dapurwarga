@extends('layouts.app')

@section('title', 'Jasa Warga - DapurWarga')

@section('content')
    <div class="py-section-gap">
        <!-- Header Section -->
        <section class="mb-section-gap max-w-3xl">
            <span class="inline-block bg-secondary-container text-on-secondary-container text-caption font-caption px-3 py-1 rounded-full mb-stack-md uppercase tracking-wider font-bold">JASA WARGA</span>
            <h1 class="text-headline-lg-mobile md:text-headline-lg font-headline-lg-mobile md:font-headline-lg text-primary mb-stack-sm">Pusat Layanan &amp; Keahlian Tetangga</h1>
            <p class="text-body-lg font-body-lg text-on-surface-variant">Temukan jasa terpercaya dari warga sekitar untuk kebutuhan harian Anda.</p>
        </section>

        <!-- Filter Pills -->
        <section class="mb-section-gap overflow-x-auto pb-4 hide-scrollbar">
            <div class="flex gap-3 min-w-max">
                <button class="px-5 py-2 rounded-full bg-primary text-on-primary text-label-md font-label-md transition-all">Semua Jasa</button>
                <button class="px-5 py-2 rounded-full bg-surface-container-low text-on-surface-variant hover:bg-surface-container text-label-md font-label-md border border-outline-variant transition-all">Perbaikan Rumah</button>
                <button class="px-5 py-2 rounded-full bg-surface-container-low text-on-surface-variant hover:bg-surface-container text-label-md font-label-md border border-outline-variant transition-all">Pendidikan &amp; Les</button>
                <button class="px-5 py-2 rounded-full bg-surface-container-low text-on-surface-variant hover:bg-surface-container text-label-md font-label-md border border-outline-variant transition-all">Rumah Tangga</button>
                <button class="px-5 py-2 rounded-full bg-surface-container-low text-on-surface-variant hover:bg-surface-container text-label-md font-label-md border border-outline-variant transition-all">Kecantikan</button>
                <button class="px-5 py-2 rounded-full bg-surface-container-low text-on-surface-variant hover:bg-surface-container text-label-md font-label-md border border-outline-variant transition-all">Kesehatan</button>
            </div>
        </section>

        <!-- Service Grid -->
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card 1 -->
            <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl p-6 flex flex-col h-full hover:shadow-[0_4px_12px_rgba(30,27,75,0.05)] transition-shadow duration-300">
                <div class="flex justify-between items-start mb-4">
                    <span class="bg-surface-container-high text-on-surface-variant text-caption font-caption px-2 py-1 rounded">RT 01</span>
                    <span class="text-primary font-bold text-label-md font-label-md">Mulai Rp 75.000</span>
                </div>
                <h3 class="text-headline-md font-headline-md text-primary mb-2 line-clamp-2">Service AC &amp; Elektronik Bergaransi</h3>
                <p class="text-body-md font-body-md text-on-surface-variant mb-4 flex-grow line-clamp-3">Melayani cuci AC, isi freon, dan perbaikan elektronik ringan. Jujur dan bergaransi.</p>
                <div class="border-t border-surface-variant pt-4 mt-auto">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-tertiary-container flex items-center justify-center text-on-tertiary-container">
                            <span class="material-symbols-outlined">person</span>
                        </div>
                        <div>
                            <p class="text-label-md font-label-md text-on-surface">Pak Bambang</p>
                            <p class="text-caption font-caption text-on-surface-variant">Penyedia Jasa</p>
                        </div>
                    </div>
                    <button class="w-full bg-secondary text-on-secondary rounded-lg py-2 px-4 text-label-md font-label-md flex items-center justify-center gap-2 hover:bg-opacity-90 transition-all">
                        <span class="material-symbols-outlined text-lg">chat</span>
                        Hubungi via WhatsApp
                    </button>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl p-6 flex flex-col h-full hover:shadow-[0_4px_12px_rgba(30,27,75,0.05)] transition-shadow duration-300">
                <div class="flex justify-between items-start mb-4">
                    <span class="bg-surface-container-high text-on-surface-variant text-caption font-caption px-2 py-1 rounded">RT 03</span>
                    <span class="text-primary font-bold text-label-md font-label-md">Rp 50.000 / Sesi</span>
                </div>
                <h3 class="text-headline-md font-headline-md text-primary mb-2 line-clamp-2">Les Privat Matematika &amp; IPA SD/SMP</h3>
                <p class="text-body-md font-body-md text-on-surface-variant mb-4 flex-grow line-clamp-3">Bimbingan belajar sabar dan telaten untuk anak sekolah. Jam fleksibel sore hari.</p>
                <div class="border-t border-surface-variant pt-4 mt-auto">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-tertiary-container flex items-center justify-center text-on-tertiary-container">
                            <span class="material-symbols-outlined">person</span>
                        </div>
                        <div>
                            <p class="text-label-md font-label-md text-on-surface">Ibu Ratna</p>
                            <p class="text-caption font-caption text-on-surface-variant">Penyedia Jasa</p>
                        </div>
                    </div>
                    <button class="w-full bg-secondary text-on-secondary rounded-lg py-2 px-4 text-label-md font-label-md flex items-center justify-center gap-2 hover:bg-opacity-90 transition-all">
                        <span class="material-symbols-outlined text-lg">chat</span>
                        Hubungi via WhatsApp
                    </button>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl p-6 flex flex-col h-full hover:shadow-[0_4px_12px_rgba(30,27,75,0.05)] transition-shadow duration-300">
                <div class="flex justify-between items-start mb-4">
                    <span class="bg-surface-container-high text-on-surface-variant text-caption font-caption px-2 py-1 rounded">RT 05</span>
                    <span class="text-primary font-bold text-label-md font-label-md">Tarif Negosiasi</span>
                </div>
                <h3 class="text-headline-md font-headline-md text-primary mb-2 line-clamp-2">Jasa Bersih Rumah &amp; Setrika</h3>
                <p class="text-body-md font-body-md text-on-surface-variant mb-4 flex-grow line-clamp-3">Membantu harian untuk merapikan rumah dan menyetrika pakaian. Rapi dan amanah.</p>
                <div class="border-t border-surface-variant pt-4 mt-auto">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-tertiary-container flex items-center justify-center text-on-tertiary-container">
                            <span class="material-symbols-outlined">person</span>
                        </div>
                        <div>
                            <p class="text-label-md font-label-md text-on-surface">Mbak Siti</p>
                            <p class="text-caption font-caption text-on-surface-variant">Penyedia Jasa</p>
                        </div>
                    </div>
                    <button class="w-full bg-secondary text-on-secondary rounded-lg py-2 px-4 text-label-md font-label-md flex items-center justify-center gap-2 hover:bg-opacity-90 transition-all">
                        <span class="material-symbols-outlined text-lg">chat</span>
                        Hubungi via WhatsApp
                    </button>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl p-6 flex flex-col h-full hover:shadow-[0_4px_12px_rgba(30,27,75,0.05)] transition-shadow duration-300">
                <div class="flex justify-between items-start mb-4">
                    <span class="bg-surface-container-high text-on-surface-variant text-caption font-caption px-2 py-1 rounded">RT 02</span>
                    <span class="text-primary font-bold text-label-md font-label-md">Rp 35.000</span>
                </div>
                <h3 class="text-headline-md font-headline-md text-primary mb-2 line-clamp-2">Potong Rambut Panggilan (Home Service)</h3>
                <p class="text-body-md font-body-md text-on-surface-variant mb-4 flex-grow line-clamp-3">Cukur rambut pria dan anak-anak langsung di rumah Anda. Bersih dan profesional.</p>
                <div class="border-t border-surface-variant pt-4 mt-auto">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-tertiary-container flex items-center justify-center text-on-tertiary-container">
                            <span class="material-symbols-outlined">person</span>
                        </div>
                        <div>
                            <p class="text-label-md font-label-md text-on-surface">Mas Doni</p>
                            <p class="text-caption font-caption text-on-surface-variant">Penyedia Jasa</p>
                        </div>
                    </div>
                    <button class="w-full bg-secondary text-on-secondary rounded-lg py-2 px-4 text-label-md font-label-md flex items-center justify-center gap-2 hover:bg-opacity-90 transition-all">
                        <span class="material-symbols-outlined text-lg">chat</span>
                        Hubungi via WhatsApp
                    </button>
                </div>
            </div>
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