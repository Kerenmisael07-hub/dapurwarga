<!DOCTYPE html>
<html lang="id"><head>
@include('admin.partials.head', ['title' => 'Menu Kuliner & Lapak'])
</head>
<body class="bg-surface text-on-surface h-screen flex overflow-hidden">
@include('admin.partials.sidebar', ['active' => 'kuliner'])
<main class="flex-1 flex flex-col h-full overflow-hidden bg-background">
@include('admin.partials.nav', ['active' => 'kuliner'])
<div class="flex-1 overflow-y-auto p-margin-mobile md:p-gutter">
    <div class="max-w-container-max mx-auto space-y-stack-lg pb-section-gap">
        <div>
            <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary">Menu Kuliner & Lapak</h1>
            <p class="font-body-md text-body-md text-on-surface-variant mt-1">Lihat semua menu, moderasi ketersediaan, buka/tutup lapak penjual.</p>
        </div>
        @if (session('success')) <div class="bg-secondary-container text-on-secondary-container font-label-md text-label-md px-4 py-3 rounded-lg">{{ session('success') }}</div> @endif
        @if ($errors->any()) <div class="bg-error-container text-on-error-container font-label-md text-label-md px-4 py-3 rounded-lg">{{ implode(', ', $errors->all()) }}</div> @endif
        <form method="GET" class="flex gap-2">
            <input name="q" value="{{ $search }}" placeholder="Cari menu, kategori, lapak/penjual" class="rounded-lg border border-outline-variant px-3 py-2 text-sm">
            <button class="bg-primary text-on-primary px-4 py-2 rounded-lg text-sm">Cari</button>
        </form>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($menus as $menu)
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4">
                <h3 class="font-label-md text-label-md">{{ $menu->name }}</h3>
                <p class="text-xs text-on-surface-variant">{{ $menu->seller?->nama_lapak }} ({{ $menu->seller?->name }})</p>
                <div class="flex items-center justify-between mt-2">
                    <span>{{ $menu->available ? 'Tersedia' : 'Habis' }}</span>
                    <div class="flex gap-2 text-xs">
                        <form method="POST" action="{{ route('admin.kuliner.toggle', $menu) }}">@csrf @method('PATCH')<button>{{ $menu->available ? 'Tandai Habis' : 'Tersedia Lagi' }}</button></form>
                        <form method="POST" action="{{ route('admin.kuliner.destroy', $menu) }}" onsubmit="return confirm('Hapus menu?')">@csrf @method('DELETE')<button class="text-error">Hapus</button></form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div>{{ $menus->links() }}</div>
    </div>
</div>
</main>
</body></html>