<!DOCTYPE html>
<html lang="id"><head>
@include('layanan.partials.head', ['title' => 'Kategori & Satuan Tarif'])
</head>
<body class="bg-surface text-on-surface h-screen flex overflow-hidden">
@include('layanan.partials.sidebar', ['active' => 'opsi'])
<!-- Main Content Area -->
<main class="flex-1 flex flex-col h-full overflow-hidden bg-background">
@include('layanan.partials.nav', ['active' => 'opsi'])
<!-- Content Canvas -->
<div class="flex-1 overflow-y-auto p-margin-mobile md:p-gutter">
    <div class="max-w-container-max mx-auto space-y-stack-lg pb-section-gap">
        @if (session('success'))
            <div class="bg-secondary-container text-on-secondary-container font-label-md text-label-md px-4 py-3 rounded-lg flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">check_circle</span>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-error-container text-on-error-container font-label-md text-label-md px-4 py-3 rounded-lg flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">error</span>
                {{ session('error') }}
            </div>
        @endif
        @if (isset($errors) && $errors->any())
            <div class="bg-error-container text-on-error-container font-label-md text-label-md px-4 py-3 rounded-lg flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">error</span>
                {{ $errors->first() }}
            </div>
        @endif
        <!-- Page Header -->
        <div>
            <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary">Kategori &amp; Satuan Tarif</h1>
            <p class="font-body-md text-body-md text-on-surface-variant mt-1">Isi sendiri daftar kategori dan satuan tarif Anda. Pilihan ini akan muncul saat menambah atau mengubah layanan.</p>
        </div>
        <!-- Two Column Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-stack-lg">
            @php
                $cards = [
                    [
                        'type' => 'category',
                        'title' => 'Kategori Layanan',
                        'desc' => 'Kelompokkan jenis jasa yang Anda tawarkan, cth: Pertukangan, Kecantikan.',
                        'icon' => 'category',
                        'placeholder' => 'cth: Pertukangan',
                        'items' => $categories,
                    ],
                    [
                        'type' => 'unit',
                        'title' => 'Satuan Tarif',
                        'desc' => 'Tentukan satuan penghitungan tarif, cth: Panggilan, Jam, Unit.',
                        'icon' => 'straighten',
                        'placeholder' => 'cth: Panggilan',
                        'items' => $units,
                    ],
                ];
            @endphp
            @foreach ($cards as $card)
                <div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm flex flex-col overflow-hidden">
                    <div class="p-6 border-b border-outline-variant flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary-container bg-primary-fixed p-2 rounded-full">{{ $card['icon'] }}</span>
                        <div>
                            <h2 class="font-headline-md text-headline-md text-on-surface">{{ $card['title'] }}</h2>
                            <p class="font-caption text-caption text-on-surface-variant mt-0.5">{{ $card['desc'] }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('layanan.opsi.store') }}" class="p-6 flex items-start gap-3 border-b border-outline-variant">
                        @csrf
                        <input type="hidden" name="type" value="{{ $card['type'] }}">
                        <input type="text" name="name" required maxlength="50" placeholder="{{ $card['placeholder'] }}"
                            class="flex-grow rounded-lg border border-outline-variant bg-surface-container-low px-4 py-2.5 font-body-md text-body-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                        <button type="submit" class="bg-primary text-on-primary px-4 py-2.5 rounded-lg font-label-md text-label-md flex items-center gap-1.5 hover:bg-primary/90 transition-colors shrink-0">
                            <span class="material-symbols-outlined text-[18px]">add</span>
                            Tambah
                        </button>
                    </form>
                    <div class="p-6 flex-grow">
                        @if ($card['items']->isEmpty())
                            <p class="font-body-md text-body-md text-on-surface-variant text-center py-6">Belum ada data. Tambahkan lewat kolom di atas.</p>
                        @else
                            <div class="flex flex-wrap gap-2">
                                @foreach ($card['items'] as $item)
                                    <span class="inline-flex items-center gap-1.5 bg-surface-container-low border border-outline-variant rounded-full pl-3.5 pr-1.5 py-1.5 font-label-md text-label-md text-on-surface">
                                        {{ $item->name }}
                                        <form method="POST" action="{{ route('layanan.opsi.destroy', $item) }}" onsubmit="return confirm('Hapus {{ $item->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus" class="w-6 h-6 flex items-center justify-center rounded-full text-on-surface-variant hover:bg-error-container hover:text-on-error-container transition-colors">
                                                <span class="material-symbols-outlined text-[16px]">close</span>
                                            </button>
                                        </form>
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
</main>
</body></html>
