<!DOCTYPE html>
<html lang="id"><head>
@include('admin.partials.head', ['title' => 'Pengguna & Peran'])
</head>
<body class="bg-surface text-on-surface h-screen flex overflow-hidden">
@include('admin.partials.sidebar', ['active' => 'pengguna'])
<main class="flex-1 flex flex-col h-full overflow-hidden bg-background">
@include('admin.partials.nav', ['active' => 'pengguna'])
<div class="flex-1 overflow-y-auto p-margin-mobile md:p-gutter">
    <div class="max-w-container-max mx-auto space-y-stack-lg pb-section-gap">
        <div>
            <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary">Pengguna & Peran</h1>
            <p class="font-body-md text-body-md text-on-surface-variant mt-1">Kelola semua pengguna, ubah peran, aktif/nonaktifkan, atau hapus akun.</p>
        </div>
        @if (session('success'))
            <div class="bg-secondary-container text-on-secondary-container font-label-md text-label-md px-4 py-3 rounded-lg flex items-center gap-2">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="bg-error-container text-on-error-container font-label-md text-label-md px-4 py-3 rounded-lg flex items-start gap-2">
                <div>
                    @foreach ($errors->all() as $message)
                        <p>{{ $message }}</p>
                    @endforeach
                </div>
            </div>
        @endif
        <form method="GET" action="{{ route('admin.pengguna.index') }}" class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4 flex flex-wrap gap-3">
            <input name="q" value="{{ $search }}" placeholder="Cari nama/email" class="rounded-lg border border-outline-variant bg-surface-container-low px-3 py-2 text-sm">
            <select name="role" class="rounded-lg border border-outline-variant bg-surface-container-low px-3 py-2 text-sm">
                <option value="">Semua Peran</option>
                @foreach ($roles as $r)
                    <option value="{{ $r }}" {{ $role === $r ? 'selected' : '' }}>{{ strtoupper($r) }}</option>
                @endforeach
            </select>
            <button class="bg-primary text-on-primary px-4 py-2 rounded-lg text-sm">Filter</button>
            @if ($search || $role)
                <a href="{{ route('admin.pengguna.index') }}" class="px-4 py-2 rounded-lg text-sm border border-outline-variant">Reset</a>
            @endif
        </form>
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-surface-container">
                        <tr>
                            <th class="text-left px-4 py-2">Nama</th>
                            <th class="text-left px-4 py-2">Email</th>
                            <th class="text-left px-4 py-2">Peran</th>
                            <th class="text-left px-4 py-2">Status</th>
                            <th class="text-left px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $u)
                            <tr class="border-t border-outline-variant">
                                <td class="px-4 py-2">{{ $u->name }}</td>
                                <td class="px-4 py-2">{{ $u->email }}</td>
                                <td class="px-4 py-2">
                                    <form method="POST" action="{{ route('admin.pengguna.update', $u) }}" class="flex items-center gap-2">
                                        @csrf @method('PUT')
                                        <select name="role" class="rounded border border-outline-variant px-2 py-1 text-xs">
                                            @foreach ($roles as $r)
                                                <option value="{{ $r }}" {{ $u->role === $r ? 'selected' : '' }}>{{ strtoupper($r) }}</option>
                                            @endforeach
                                        </select>
                                        <button class="text-xs text-primary">Simpan</button>
                                    </form>
                                </td>
                                <td class="px-4 py-2">{{ $u->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                                <td class="px-4 py-2 flex items-center gap-2">
                                    <form method="POST" action="{{ route('admin.pengguna.toggle-aktif', $u) }}">
                                        @csrf @method('PATCH')
                                        <button class="text-xs {{ $u->is_active ? 'text-error' : 'text-primary' }}" {{ $u->id === auth()->id() ? 'disabled' : '' }}>
                                            {{ $u->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.pengguna.destroy', $u) }}" onsubmit="return confirm('Hapus pengguna ini?')">
                                        @csrf @method('DELETE')
                                        <button class="text-xs text-error" {{ $u->id === auth()->id() ? 'disabled' : '' }}>Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4">{{ $users->links() }}</div>
        </div>
    </div>
</div>
</main>
</body></html>