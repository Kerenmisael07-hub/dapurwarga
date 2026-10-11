<!DOCTYPE html>
<html lang="id"><head>
@include('admin.partials.head', ['title' => 'Info RT'])
</head>
<body class="bg-surface text-on-surface h-screen flex overflow-hidden">
@include('admin.partials.sidebar', ['active' => 'info-rt'])
<main class="flex-1 flex flex-col h-full overflow-hidden bg-background">
@include('admin.partials.nav', ['active' => 'info-rt'])
<div class="flex-1 overflow-y-auto p-margin-mobile md:p-gutter">
    <div class="max-w-container-max mx-auto space-y-stack-lg pb-section-gap">
        <div>
            <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary">Info RT</h1>
            <p class="font-body-md text-body-md text-on-surface-variant mt-1">Kelola konten yang tampil di halaman publik <a href="{{ route('info-rt') }}" target="_blank" class="text-primary underline">Pusat Informasi Warga</a>.</p>
        </div>
        @if (session('success')) <div class="bg-secondary-container text-on-secondary-container font-label-md text-label-md px-4 py-3 rounded-lg flex items-center gap-2">{{ session('success') }}</div> @endif
        @if ($errors->any())
            <div class="bg-error-container text-on-error-container font-label-md text-label-md px-4 py-3 rounded-lg">
                <ul class="list-disc list-inside">@foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach</ul>
            </div>
        @endif

        <!-- Setelan -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6">
            <h2 class="font-headline-md text-headline-md text-primary mb-4">Setelan & Statistik Lingkungan</h2>
            <form method="POST" action="{{ route('admin.info-rt.settings.update') }}" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @csrf
                <div class="flex flex-col gap-2 sm:col-span-2">
                    <label class="font-label-md text-label-md">Status Lingkungan</label>
                    <input name="status_text" value="{{ $settings['status_text'] ?? '' }}" class="rounded-lg border border-outline-variant bg-surface-container-low px-3 py-2 text-sm">
                </div>
                <div class="flex flex-col gap-2">
                    <label class="font-label-md text-label-md">Lapak Aktif</label>
                    <input name="lapak_aktif" value="{{ $settings['lapak_aktif'] ?? '' }}" class="rounded-lg border border-outline-variant bg-surface-container-low px-3 py-2 text-sm">
                </div>
                <div class="flex flex-col gap-2">
                    <label class="font-label-md text-label-md">Total Warga</label>
                    <input name="total_warga" value="{{ $settings['total_warga'] ?? '' }}" class="rounded-lg border border-outline-variant bg-surface-container-low px-3 py-2 text-sm">
                </div>
                <div class="flex flex-col gap-2">
                    <label class="font-label-md text-label-md">Kegiatan Bulan Ini</label>
                    <input name="kegiatan_bulan_ini" value="{{ $settings['kegiatan_bulan_ini'] ?? '' }}" class="rounded-lg border border-outline-variant bg-surface-container-low px-3 py-2 text-sm">
                </div>
                <div class="sm:col-span-2">
                    <button class="bg-primary text-on-primary px-5 py-2.5 rounded-lg text-sm">Simpan Setelan</button>
                </div>
            </form>
        </div>

        <!-- Pengumuman -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6">
            <h2 class="font-headline-md text-headline-md text-primary mb-4">Pengumuman</h2>
            <form method="POST" action="{{ route('admin.info-rt.announcements.store') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-6">
                @csrf
                <input name="title" placeholder="Judul" required class="sm:col-span-2 rounded-lg border border-outline-variant bg-surface-container-low px-3 py-2 text-sm">
                <input name="category" placeholder="Kategori (mis. Segera)" class="rounded-lg border border-outline-variant bg-surface-container-low px-3 py-2 text-sm">
                <input name="tanggal" type="date" class="rounded-lg border border-outline-variant bg-surface-container-low px-3 py-2 text-sm">
                <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_urgent" value="1"> Tandai penting</label>
                <button class="bg-primary text-on-primary px-4 py-2 rounded-lg text-sm">Tambah</button>
                <textarea name="body" rows="2" placeholder="Isi pengumuman" class="sm:col-span-3 rounded-lg border border-outline-variant bg-surface-container-low px-3 py-2 text-sm"></textarea>
            </form>
            <div class="flex flex-col gap-2">
                @foreach ($announcements as $a)
                    <div class="flex items-start justify-between gap-3 border-t border-outline-variant pt-2">
                        <div>
                            <p class="font-label-md text-label-md">{{ $a->title }} @if($a->is_urgent)<span class="text-error text-xs">• penting</span>@endif</p>
                            <p class="text-xs text-on-surface-variant">{{ $a->category }} • {{ $a->tanggal?->format('d M Y') }}</p>
                        </div>
                        <form method="POST" action="{{ route('admin.info-rt.announcements.destroy', $a) }}" onsubmit="return confirm('Hapus pengumuman?')">@csrf @method('DELETE')<button class="text-error text-xs">Hapus</button></form>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">{{ $announcements->links() }}</div>
        </div>

        <!-- Kontak -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6">
            <h2 class="font-headline-md text-headline-md text-primary mb-4">Kontak Penting</h2>
            <form method="POST" action="{{ route('admin.info-rt.contacts.store') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3 mb-6">
                @csrf
                <input name="name" placeholder="Nama" required class="rounded-lg border border-outline-variant bg-surface-container-low px-3 py-2 text-sm">
                <input name="role" placeholder="Jabatan" required class="rounded-lg border border-outline-variant bg-surface-container-low px-3 py-2 text-sm">
                <input name="phone" placeholder="No. telepon" class="rounded-lg border border-outline-variant bg-surface-container-low px-3 py-2 text-sm">
                <input name="icon" placeholder="Ikon (person/call/security)" class="rounded-lg border border-outline-variant bg-surface-container-low px-3 py-2 text-sm">
                <button class="bg-primary text-on-primary px-4 py-2 rounded-lg text-sm sm:col-span-4 sm:w-fit">Tambah</button>
            </form>
            <div class="flex flex-col gap-2">
                @foreach ($contacts as $c)
                    <div class="flex items-center justify-between gap-3 border-t border-outline-variant pt-2">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">{{ $c->icon ?: 'person' }}</span>
                            <div>
                                <p class="font-label-md text-label-md">{{ $c->name }}</p>
                                <p class="text-xs text-on-surface-variant">{{ $c->role }}{{ $c->phone ? ' • '.$c->phone : '' }}</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('admin.info-rt.contacts.destroy', $c) }}" onsubmit="return confirm('Hapus kontak?')">@csrf @method('DELETE')<button class="text-error text-xs">Hapus</button></form>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">{{ $contacts->links() }}</div>
        </div>

        <!-- Galeri -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6">
            <h2 class="font-headline-md text-headline-md text-primary mb-4">Galeri Kegiatan</h2>
            <form method="POST" action="{{ route('admin.info-rt.gallery.store') }}" class="flex flex-col sm:flex-row gap-3 mb-6">
                @csrf
                <input name="image" placeholder="URL gambar (https://...)" required class="flex-1 rounded-lg border border-outline-variant bg-surface-container-low px-3 py-2 text-sm">
                <button class="bg-primary text-on-primary px-4 py-2 rounded-lg text-sm">Tambah</button>
            </form>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                @foreach ($gallery as $g)
                    <div class="relative group">
                        <img src="{{ $g->image }}" class="w-full aspect-square object-cover rounded-lg border border-outline-variant">
                        <form method="POST" action="{{ route('admin.info-rt.gallery.destroy', $g) }}" onsubmit="return confirm('Hapus gambar?')" class="absolute top-1 right-1">
                            @csrf @method('DELETE')
                            <button class="bg-error text-on-error rounded-full w-7 h-7 flex items-center justify-center"><span class="material-symbols-outlined text-[16px]">close</span></button>
                        </form>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">{{ $gallery->links() }}</div>
        </div>
    </div>
</div>
</main>
</body></html>