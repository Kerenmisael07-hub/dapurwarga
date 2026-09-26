<!DOCTYPE html>
<html lang="id"><head>
@include('seller.partials.head', ['title' => $menu ? 'Edit Menu' : 'Tambah Menu'])
</head>
<body class="bg-surface text-on-surface h-screen flex overflow-hidden">
@php
    $days = ['SEN', 'SEL', 'RAB', 'KAM', 'JUM', 'SAB', 'MIN'];
    $categories = ['Sarapan', 'Makan Siang', 'Cemilan', 'Lauk Pauk', 'Minuman'];
@endphp
@include('seller.partials.sidebar', ['active' => 'menu'])
<!-- Main Content -->
<main class="flex-1 flex flex-col h-full overflow-hidden bg-background">
@include('seller.partials.nav', ['active' => 'menu'])
    <div class="flex-1 overflow-y-auto p-margin-mobile md:p-gutter">
        <div class="max-w-2xl mx-auto space-y-stack-lg pb-section-gap">
            <div>
                <a href="{{ route('seller.dashboard') }}" class="font-label-md text-label-md text-on-surface-variant hover:text-primary flex items-center gap-1 mb-4">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span> Kembali ke Dasbor
                </a>
                <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary">{{ $menu ? 'Edit Menu Kuliner' : 'Tambah Menu Kuliner Baru' }}</h1>
                <p class="font-body-md text-body-md text-on-surface-variant mt-1">Lengkapi detail menu berikut. Setelah disimpan, menu langsung tampil di beranda DapurWarga.</p>
            </div>

            @if (isset($errors) && $errors->any())
                <div class="bg-error-container text-on-error-container font-label-md text-label-md px-4 py-3 rounded-lg">
                    Perbaiki kesalahan pada form di bawah ini.
                </div>
            @endif

            <form method="POST" action="{{ $menu ? route('seller.menu.update', $menu) : route('seller.menu.store') }}" enctype="multipart/form-data" class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 flex flex-col gap-5">
                @csrf
                @if ($menu)
                    @method('PUT')
                @endif

                <div class="flex flex-col gap-2">
                    <label for="name" class="font-label-md text-label-md text-on-surface">Nama Menu <span class="text-error">*</span></label>
                    <input id="name" name="name" type="text" required value="{{ old('name', $menu->name ?? '') }}" class="rounded-lg border border-outline-variant bg-surface-container-low px-4 py-2.5 font-body-md text-body-md focus:border-primary focus:ring-primary" placeholder="contoh: Nasi Kuning Komplit">
                    @error('name') <span class="font-caption text-caption text-error">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="description" class="font-label-md text-label-md text-on-surface">Deskripsi</label>
                    <textarea id="description" name="description" rows="3" class="rounded-lg border border-outline-variant bg-surface-container-low px-4 py-2.5 font-body-md text-body-md focus:border-primary focus:ring-primary" placeholder="Deskripsi singkat menu, bahan, dan keunggulannya">{{ old('description', $menu->description ?? '') }}</textarea>
                    @error('description') <span class="font-caption text-caption text-error">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="flex flex-col gap-2">
                        <label for="category" class="font-label-md text-label-md text-on-surface">Kategori <span class="text-error">*</span></label>
                        <select id="category" name="category" class="rounded-lg border border-outline-variant bg-surface-container-low px-4 py-2.5 font-body-md text-body-md focus:border-primary focus:ring-primary">
                            @foreach ($categories as $category)
                                <option value="{{ $category }}" {{ old('category', $menu->category ?? 'Makan Siang') === $category ? 'selected' : '' }}>{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="price" class="font-label-md text-label-md text-on-surface">Harga (Rp) <span class="text-error">*</span></label>
                        <input id="price" name="price" type="number" min="0" required value="{{ old('price', $menu->price ?? '') }}" class="rounded-lg border border-outline-variant bg-surface-container-low px-4 py-2.5 font-body-md text-body-md focus:border-primary focus:ring-primary" placeholder="25000">
                        @error('price') <span class="font-caption text-caption text-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="flex flex-col gap-2">
                        <label for="stock" class="font-label-md text-label-md text-on-surface">Stok / Kuota Porsi <span class="text-error">*</span></label>
                        <input id="stock" name="stock" type="number" min="0" required value="{{ old('stock', $menu->stock ?? '') }}" class="rounded-lg border border-outline-variant bg-surface-container-low px-4 py-2.5 font-body-md text-body-md focus:border-primary focus:ring-primary" placeholder="20">
                        @error('stock') <span class="font-caption text-caption text-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="image" class="font-label-md text-label-md text-on-surface">Foto Menu</label>
                        <input id="image" name="image" type="file" accept="image/*" onchange="previewImage(this)" class="block w-full text-sm text-on-surface border border-outline-variant rounded-lg bg-surface-container-low file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:bg-primary file:text-on-primary file:font-label-md file:text-label-md hover:file:bg-primary/90 cursor-pointer transition-colors">
                        <p class="font-caption text-caption text-on-surface-variant">Format bebas (JPG, PNG, WEBP, GIF, BMP, dan lainnya). {{ \App\Rules\GambarUpload::infoUkuran() }}.</p>
                        @error('image') <span class="font-caption text-caption text-error">{{ $message }}</span> @enderror
                        <div id="image-preview" class="mt-2 {{ $menu && $menu->getRawOriginal('image_url') ? '' : 'hidden' }}">
                            <img src="{{ $menu ? $menu->image_url : '' }}" alt="Preview" class="w-40 h-40 object-cover rounded-lg border border-outline-variant">
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <span class="font-label-md text-label-md text-on-surface">Hari Tersedia</span>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($days as $day)
                            <label class="flex items-center gap-2 px-3 py-2 rounded-lg border border-outline-variant bg-surface-container-low font-label-md text-label-md cursor-pointer has-[:checked]:bg-primary-fixed has-[:checked]:border-primary has-[:checked]:text-primary-container transition-colors">
                                <input type="checkbox" name="days[]" value="{{ $day }}" class="accent-primary" {{ in_array($day, old('days', $menu->days ?? [])) ? 'checked' : '' }}>
                                {{ $day }}
                            </label>
                        @endforeach
                    </div>
                    @error('days') <span class="font-caption text-caption text-error">{{ $message }}</span> @enderror
                </div>

                @if ($menu)
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="available" value="1" class="w-5 h-5 accent-secondary" {{ old('available', $menu->available) ? 'checked' : '' }}>
                        <span class="font-label-md text-label-md text-on-surface">Menu tersedia (tampil di beranda)</span>
                    </label>
                @endif

                <div class="flex flex-col sm:flex-row gap-3 pt-2 border-t border-outline-variant">
                    <button type="submit" class="bg-primary text-on-primary px-6 py-3 rounded-lg font-label-md text-label-md flex items-center justify-center gap-2 hover:bg-primary/90 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        {{ $menu ? 'Simpan Perubahan' : 'Simpan Menu' }}
                    </button>
                    <a href="{{ route('seller.dashboard') }}" class="px-6 py-3 rounded-lg font-label-md text-label-md border border-outline-variant text-on-surface hover:bg-surface-container transition-colors text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>
<script>
    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        const img = preview.querySelector('img');
        if (input.files && input.files[0]) {
            img.src = URL.createObjectURL(input.files[0]);
            preview.classList.remove('hidden');
        }
    }
</script>
</body></html>
