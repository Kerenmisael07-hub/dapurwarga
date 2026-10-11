<!DOCTYPE html>
<html lang="id"><head>
@include('layanan.partials.head', ['title' => $service ? 'Edit Layanan Jasa' : 'Tambah Layanan Jasa'])
</head>
<body class="bg-surface text-on-surface h-screen flex overflow-hidden">
@php
    $activeNav = $service ? 'dashboard' : 'create';
@endphp
@include('layanan.partials.sidebar', ['active' => $activeNav])
<!-- Main Content Area -->
<main class="flex-1 flex flex-col h-full overflow-hidden bg-background">
@include('layanan.partials.nav', ['active' => $activeNav])
<!-- Content Canvas -->
<div class="flex-1 overflow-y-auto p-margin-mobile md:p-gutter">
    <div class="max-w-3xl mx-auto space-y-stack-lg pb-section-gap">
        <!-- Breadcrumb / Back -->
        <a href="{{ route('layanan.dashboard') }}" class="inline-flex items-center gap-1.5 font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali ke Dashboard
        </a>
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
            <div>
                <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary">{{ $service ? 'Edit Layanan Jasa' : 'Tambah Layanan Jasa Baru' }}</h1>
                <p class="font-body-md text-body-md text-on-surface-variant mt-1">Lengkapi detail keahlian yang Anda tawarkan ke warga sekitar.</p>
            </div>
            <a href="{{ route('layanan.opsi.index') }}" class="inline-flex items-center gap-1.5 font-label-md text-label-md text-secondary hover:underline shrink-0">
                <span class="material-symbols-outlined text-[18px]">tune</span>
                Kelola Kategori &amp; Satuan
            </a>
        </div>
        <!-- Form Card -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm overflow-hidden">
            <form method="POST" enctype="multipart/form-data" action="{{ $service ? route('layanan.update', $service) : route('layanan.store') }}" class="p-6 space-y-5">
                @csrf
                @if ($service)
                    @method('PUT')
                @endif

                <div>
                    <label for="name" class="block font-label-md text-label-md text-on-surface mb-1.5">Nama Layanan <span class="text-error">*</span></label>
                    <input id="name" name="name" type="text" required value="{{ old('name', $service->name ?? '') }}" placeholder="cth: Servis AC & Perbaikan Listrik"
                        class="w-full rounded-lg border @error('name') border-error @else border-outline-variant @enderror bg-surface-container-low px-4 py-2.5 font-body-md text-body-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                    @error('name') <span class="font-caption text-caption text-error">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="category" class="block font-label-md text-label-md text-on-surface mb-1.5">Kategori <span class="text-error">*</span></label>
                        <input id="category" name="category" type="text" list="category-options" required value="{{ old('category', $service->category ?? '') }}" placeholder="cth: Pertukangan"
                            class="w-full rounded-lg border @error('category') border-error @else border-outline-variant @enderror bg-surface-container-low px-4 py-2.5 font-body-md text-body-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                        <datalist id="category-options">
                            @foreach ($categories ?? [] as $category)
                                <option value="{{ $category }}">
                            @endforeach
                        </datalist>
                        @error('category') <span class="font-caption text-caption text-error">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="status" class="block font-label-md text-label-md text-on-surface mb-1.5">Status Ketersediaan <span class="text-error">*</span></label>
                        <select id="status" name="status" required
                            class="w-full rounded-lg border border-outline-variant bg-surface-container-low px-4 py-2.5 font-body-md text-body-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                            <option value="tersedia" @selected(old('status', $service->status ?? 'tersedia') === 'tersedia')>Tersedia</option>
                            <option value="sibuk" @selected(old('status', $service->status ?? 'tersedia') === 'sibuk')>Sedang Sibuk</option>
                        </select>
                        @error('status') <span class="font-caption text-caption text-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="price" class="block font-label-md text-label-md text-on-surface mb-1.5">Tarif (Rp) <span class="text-error">*</span></label>
                        <input id="price" name="price" type="number" min="0" step="1000" required value="{{ old('price', $service->price ?? 0) }}"
                            class="w-full rounded-lg border @error('price') border-error @else border-outline-variant @enderror bg-surface-container-low px-4 py-2.5 font-body-md text-body-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                        @error('price') <span class="font-caption text-caption text-error">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="price_unit" class="block font-label-md text-label-md text-on-surface mb-1.5">Satuan Tarif <span class="text-error">*</span></label>
                        <input id="price_unit" name="price_unit" type="text" list="unit-options" required value="{{ old('price_unit', $service->price_unit ?? '') }}" placeholder="cth: Panggilan"
                            class="w-full rounded-lg border @error('price_unit') border-error @else border-outline-variant @enderror bg-surface-container-low px-4 py-2.5 font-body-md text-body-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                        <datalist id="unit-options">
                            @foreach ($units ?? [] as $unit)
                                <option value="{{ $unit }}">
                            @endforeach
                        </datalist>
                        @error('price_unit') <span class="font-caption text-caption text-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="block font-label-md text-label-md text-on-surface mb-1.5">Deskripsi Layanan</label>
                    <textarea id="description" name="description" rows="3" placeholder="Jelaskan cakupan pekerjaan, garansi, atau catatan penting..."
                        class="w-full rounded-lg border @error('description') border-error @else border-outline-variant @enderror bg-surface-container-low px-4 py-2.5 font-body-md text-body-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">{{ old('description', $service->description ?? '') }}</textarea>
                    @error('description') <span class="font-caption text-caption text-error">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="foto" class="block font-label-md text-label-md text-on-surface mb-1.5">Foto Layanan (Opsional)</label>
                    <label id="foto-dropzone" for="foto"
                        class="mt-1.5 flex flex-col items-center justify-center gap-3 w-full rounded-lg border-2 border-dashed @error('foto') border-error @else border-outline-variant @enderror bg-surface-container-low px-6 py-8 cursor-pointer text-center hover:border-primary hover:bg-surface-container transition-colors">
                        <span class="material-symbols-outlined text-4xl text-on-surface-variant">add_photo_alternate</span>
                        <span class="font-label-md text-label-md font-bold text-on-surface">Klik untuk unggah atau seret &amp; lepas foto di sini</span>
                        <span class="font-caption text-caption text-on-surface-variant">Format JPG, PNG, atau WEBP (Maks. 5 MB). Rasio 1:1 (persegi) sangat disarankan.</span>
                        <img id="foto-preview" src="{{ $service?->foto ? asset($service->foto) : '' }}" alt="Pratinjau foto layanan"
                            class="max-h-52 w-auto max-w-full rounded-lg object-cover {{ $service?->foto ? '' : 'hidden' }}">
                        <span id="foto-filename" class="hidden font-caption text-caption text-on-surface-variant"></span>
                        <input id="foto" name="foto" type="file" accept="image/*" class="sr-only">
                    </label>
                    @error('foto') <span class="font-caption text-caption text-error">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="whatsapp_number" class="block font-label-md text-label-md text-on-surface mb-1.5">Nomor WhatsApp</label>
                    <input id="whatsapp_number" name="whatsapp_number" type="text" value="{{ old('whatsapp_number', $service->whatsapp_number ?? '') }}" placeholder="0812xxxxxxxx"
                        class="w-full rounded-lg border @error('whatsapp_number') border-error @else border-outline-variant @enderror bg-surface-container-low px-4 py-2.5 font-body-md text-body-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                    <p class="font-caption text-caption text-on-surface-variant mt-1">Kosongkan untuk memakai nomor WhatsApp akun Anda secara default.</p>
                    @error('whatsapp_number') <span class="font-caption text-caption text-error">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center justify-end gap-3 pt-2 border-t border-outline-variant">
                    <a href="{{ route('layanan.dashboard') }}" class="px-4 py-2.5 rounded-lg font-label-md text-label-md text-on-surface-variant bg-surface-container hover:bg-surface-container-high transition-colors">Batal</a>
                    <button type="submit" class="px-4 py-2.5 rounded-lg font-label-md text-label-md text-on-primary bg-primary hover:bg-primary/90 active:scale-95 transition-all shadow-sm">
                        {{ $service ? 'Simpan Perubahan' : 'Tambahkan Layanan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</main>
<script>
    const fotoInput = document.getElementById('foto');
    const fotoDropzone = document.getElementById('foto-dropzone');
    const fotoPreview = document.getElementById('foto-preview');
    const fotoFilename = document.getElementById('foto-filename');

    function showFotoPreview(file) {
        if (!file || !file.type.startsWith('image/')) {
            return;
        }

        fotoPreview.src = URL.createObjectURL(file);
        fotoPreview.classList.remove('hidden');
        fotoFilename.textContent = file.name;
        fotoFilename.classList.remove('hidden');
    }

    fotoInput.addEventListener('change', () => showFotoPreview(fotoInput.files[0]));

    ['dragenter', 'dragover'].forEach((event) => {
        fotoDropzone.addEventListener(event, (e) => {
            e.preventDefault();
            fotoDropzone.classList.add('border-primary', 'bg-surface-container');
        });
    });

    ['dragleave', 'drop'].forEach((event) => {
        fotoDropzone.addEventListener(event, (e) => {
            e.preventDefault();
            fotoDropzone.classList.remove('border-primary', 'bg-surface-container');
        });
    });

    fotoDropzone.addEventListener('drop', (e) => {
        const file = e.dataTransfer.files[0];

        if (file) {
            fotoInput.files = e.dataTransfer.files;
            showFotoPreview(file);
        }
    });

    ['dragover', 'drop'].forEach((event) => {
        window.addEventListener(event, (e) => e.preventDefault());
    });
</script>
</body></html>
