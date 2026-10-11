<!DOCTYPE html>
<html lang="id"><head>
@include('layanan.partials.head', ['title' => 'Dashboard Layanan'])
</head>
<body class="bg-surface text-on-surface h-screen flex overflow-hidden">
@include('layanan.partials.sidebar', ['active' => 'dashboard'])
<!-- Main Content Area -->
<main class="flex-1 flex flex-col h-full overflow-hidden bg-background">
@include('layanan.partials.nav', ['active' => 'dashboard'])
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
        <!-- Page Header -->
        <div>
            <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary">Manajemen Layanan Jasa Saya</h1>
            <p class="font-body-md text-body-md text-on-surface-variant mt-1">Kelola jasa &amp; keahlian yang Anda tawarkan, atur tarif, dan pantau ketersediaannya untuk warga sekitar.</p>
        </div>
        <!-- Stats Row -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-stack-md">
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-label-md text-label-md text-on-surface-variant">Total Layanan</h3>
                    <span class="material-symbols-outlined text-primary-container bg-primary-fixed p-2 rounded-full">home_repair_service</span>
                </div>
                <p class="font-display-lg text-display-lg text-on-surface">{{ $totalLayanan }}</p>
            </div>
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-label-md text-label-md text-on-surface-variant">Tersedia</h3>
                    <span class="material-symbols-outlined text-secondary bg-secondary-fixed-dim p-2 rounded-full">check_circle</span>
                </div>
                <p class="font-display-lg text-display-lg text-on-surface">{{ $totalTersedia }}</p>
            </div>
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-label-md text-label-md text-on-surface-variant">Sedang Sibuk</h3>
                    <span class="material-symbols-outlined text-error bg-error-container p-2 rounded-full">schedule</span>
                </div>
                <p class="font-display-lg text-display-lg text-on-surface">{{ $totalSibuk }}</p>
            </div>
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-label-md text-label-md text-on-surface-variant">Kategori</h3>
                    <span class="material-symbols-outlined text-on-tertiary-container bg-tertiary-fixed p-2 rounded-full">category</span>
                </div>
                <p class="font-display-lg text-display-lg text-on-surface">{{ $totalKategori }}</p>
            </div>
        </div>
        <!-- Service Management Grid -->
        <div>
            <div class="flex items-center justify-between mb-stack-md">
                <h2 class="font-headline-md text-headline-md text-on-surface">Daftar Layanan</h2>
                <a href="{{ route('layanan') }}" class="font-label-md text-label-md text-secondary hover:underline flex items-center gap-1">
                    Lihat katalog publik
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </a>
            </div>
            @if ($services->isEmpty())
                <div class="bg-surface-container-lowest border border-dashed border-outline-variant rounded-xl p-stack-lg flex flex-col items-center justify-center text-center gap-4 min-h-[280px]">
                    <span class="material-symbols-outlined text-5xl text-on-surface-variant">handyman</span>
                    <div>
                        <h3 class="font-headline-md text-headline-md text-on-surface mb-1">Anda belum punya layanan</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">Tambahkan jasa atau keahlian pertama Anda agar langsung tampil di katalog DapurWarga untuk tetangga sekitar.</p>
                    </div>
                    <a href="{{ route('layanan.create') }}" class="bg-primary text-on-primary px-6 py-3 rounded-lg font-label-md text-label-md flex items-center gap-2 hover:bg-primary/90 transition-colors">
                        <span class="material-symbols-outlined">add</span>
                        Tambah Layanan Pertama
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-stack-md">
                    @foreach ($services as $service)
                        <div class="bg-surface-container-lowest border border-outline-variant rounded-lg shadow-sm hover:shadow-md transition-shadow flex flex-col h-full">
                            <div class="p-4 flex flex-col flex-grow">
                                <div class="flex items-center justify-between gap-2 mb-3">
                                    @include('layanan.partials.category-badge', ['category' => $service->category])
                                    <span class="{{ $service->status === 'tersedia' ? 'bg-[#0F5132] text-white' : 'bg-error text-on-error' }} text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full shrink-0">{{ $service->status === 'tersedia' ? 'Tersedia' : 'Sibuk' }}</span>
                                </div>

                                <div class="flex items-start gap-3">
                                    <div class="min-w-0 flex-1">
                                        <h3 class="text-[17px] leading-6 font-bold text-primary line-clamp-2">{{ $service->name }}</h3>
                                        <p class="text-caption font-caption text-on-surface-variant mt-0.5 line-clamp-2">{{ $service->description ?: 'Belum ada deskripsi layanan.' }}</p>
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
                            </div>
                            <div class="flex items-center justify-between px-4 pb-4 pt-2.5 gap-2">
                                <form method="POST" action="{{ route('layanan.toggle', $service) }}">
                                    @csrf
                                    <button type="submit" class="{{ $service->status === 'tersedia' ? 'text-primary bg-primary-fixed/50 hover:bg-primary-fixed' : 'text-on-surface-variant bg-surface-container hover:bg-surface-container-high' }} font-label-md text-label-md px-3 py-1.5 rounded-lg transition-colors">
                                        {{ $service->status === 'tersedia' ? 'Tandai Sibuk' : 'Tandai Tersedia' }}
                                    </button>
                                </form>
                                <div class="flex items-center gap-1">
                                    <a href="{{ route('layanan.edit', $service) }}" title="Edit layanan" class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-primary transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </a>
                                    <form method="POST" action="{{ route('layanan.destroy', $service) }}" onsubmit="return confirm('Hapus layanan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus layanan" class="p-2 rounded-lg text-on-surface-variant hover:bg-error-container hover:text-on-error-container transition-colors">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
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
