<!DOCTYPE html>
<html lang="id"><head>
@include('admin.partials.head', ['title' => 'Layanan Jasa'])
</head>
<body class="bg-surface text-on-surface h-screen flex overflow-hidden">
@include('admin.partials.sidebar', ['active' => 'layanan'])
<main class="flex-1 flex flex-col h-full overflow-hidden bg-background">
@include('admin.partials.nav', ['active' => 'layanan'])
<div class="flex-1 overflow-y-auto p-margin-mobile md:p-gutter">
    <div class="max-w-container-max mx-auto space-y-stack-lg pb-section-gap">
        <div>
            <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary">Layanan Jasa</h1>
            <p class="font-body-md text-body-md text-on-surface-variant mt-1">Moderasi semua layanan jasa.</p>
        </div>
        @if (session('success')) <div class="bg-secondary-container text-on-secondary-container font-label-md text-label-md px-4 py-3 rounded-lg">{{ session('success') }}</div> @endif
        @if ($errors->any()) <div class="bg-error-container text-on-error-container font-label-md text-label-md px-4 py-3 rounded-lg">{{ implode(', ', $errors->all()) }}</div> @endif
        <form method="GET" class="flex gap-2">
            <input name="q" value="{{ $search }}" placeholder="Cari layanan/kategori/penyedia" class="rounded-lg border border-outline-variant px-3 py-2 text-sm">
            <button class="bg-primary text-on-primary px-4 py-2 rounded-lg text-sm">Cari</button>
        </form>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($services as $service)
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4">
                <h3 class="font-label-md text-label-md">{{ $service->name }}</h3>
                <p class="text-xs text-on-surface-variant">{{ $service->seller?->name }} | {{ $service->category }}</p>
                <div class="flex items-center justify-between mt-2">
                    <span>{{ $service->status === 'tersedia' ? 'Tersedia' : 'Sibuk' }}</span>
                    <div class="flex gap-2 text-xs">
                        <form method="POST" action="{{ route('admin.layanan.toggle', $service) }}">@csrf @method('PATCH')<button>{{ $service->status === 'tersedia' ? 'Tandai Sibuk' : 'Tandai Tersedia' }}</button></form>
                        <form method="POST" action="{{ route('admin.layanan.destroy', $service) }}" onsubmit="return confirm('Hapus layanan?')">@csrf @method('DELETE')<button class="text-error">Hapus</button></form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div>{{ $services->links() }}</div>
    </div>
</div>
</main>
</body></html>