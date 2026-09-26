<!DOCTYPE html>
<html lang="id"><head>
@include('seller.partials.head', ['title' => 'Riwayat Pesanan'])
</head>
<body class="bg-surface text-on-surface h-screen flex overflow-hidden">
@include('seller.partials.sidebar', ['active' => 'pesanan'])
@php
    $bulan = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    $formatTanggal = function ($datetime) use ($bulan) {
        return $datetime->format('d') . ' ' . $bulan[(int) $datetime->format('n')] . ' ' . $datetime->format('Y H:i');
    };
    $badge = [
        'baru' => 'bg-primary-fixed text-primary-container',
        'diproses' => 'bg-tertiary-fixed text-on-tertiary-fixed-variant',
        'selesai' => 'bg-secondary-container text-on-secondary-container',
        'dibatalkan' => 'bg-error-container text-on-error-container',
    ];
    $hargaMenu = $menus->mapWithKeys(fn ($menu) => [$menu->id => $menu->price])->all();
    $oldItems = old('items');
    $itemRows = is_array($oldItems) && count($oldItems) > 0 ? array_values($oldItems) : [['menu_id' => '', 'qty' => 1]];
@endphp
<!-- Main Content Area -->
<main class="flex-1 flex flex-col h-full overflow-hidden bg-background">
@include('seller.partials.nav', ['active' => 'pesanan'])
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
            <div class="bg-error-container text-on-error-container font-label-md text-label-md px-4 py-3 rounded-lg flex items-start gap-2">
                <span class="material-symbols-outlined text-[18px]">error</span>
                <div>
                    <p>Periksa kembali isian form.</p>
                    <ul class="list-disc list-inside mt-1">
                        @foreach ($errors->all() as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary">Riwayat Pesanan</h1>
                <p class="font-body-md text-body-md text-on-surface-variant mt-1">Catat pesanan yang masuk dari WhatsApp, pantau status pengerjaannya, dan lihat total pendapatan lapak Anda.</p>
            </div>
        </div>

        <!-- Ringkasan -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-stack-md">
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-label-md text-label-md text-on-surface-variant">Total Pesanan</h3>
                    <span class="material-symbols-outlined text-primary-container bg-primary-fixed p-2 rounded-full">receipt_long</span>
                </div>
                <p class="font-display-lg text-display-lg text-on-surface">{{ $ringkasan['total_pesanan'] }}</p>
                <p class="font-caption text-caption text-on-surface-variant mt-1">Sesuai filter aktif</p>
            </div>
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-label-md text-label-md text-on-surface-variant">Total Pendapatan</h3>
                    <span class="material-symbols-outlined text-secondary-container bg-secondary-fixed-dim p-2 rounded-full text-on-secondary-fixed">payments</span>
                </div>
                <p class="font-display-lg text-display-lg text-on-surface">Rp {{ number_format($ringkasan['total_pendapatan'], 0, ',', '.') }}</p>
                <p class="font-caption text-caption text-on-surface-variant mt-1">Pesanan batal tidak dihitung</p>
            </div>
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-label-md text-label-md text-on-surface-variant">Perlu Diproses</h3>
                    <span class="material-symbols-outlined text-on-tertiary-fixed-variant bg-tertiary-fixed p-2 rounded-full">pending_actions</span>
                </div>
                <p class="font-display-lg text-display-lg text-on-surface">{{ $ringkasan['perlu_diproses'] }}</p>
                <p class="font-caption text-caption text-on-surface-variant mt-1">Status baru &amp; diproses</p>
            </div>
        </div>

        <!-- Form Catat Pesanan -->
        <details class="bg-surface-container-lowest border border-outline-variant rounded-xl" @if ($errors->any() && old('nama_pembeli')) open @endif>
            <summary class="cursor-pointer select-none px-6 py-4 flex items-center gap-3 font-label-md text-label-md text-on-surface">
                <span class="material-symbols-outlined text-primary">add_shopping_cart</span>
                Catat Pesanan Baru
            </summary>
            <div class="border-t border-outline-variant p-6">
                @if ($menus->isEmpty())
                    <div class="bg-surface-container-low border border-dashed border-outline-variant rounded-lg p-6 text-center">
                        <p class="font-body-md text-body-md text-on-surface-variant mb-4">Belum ada menu di lapak Anda, jadi pesanan belum bisa dicatat.</p>
                        <a href="{{ route('seller.menu.create') }}" class="bg-primary text-on-primary px-6 py-3 rounded-lg font-label-md text-label-md inline-flex items-center gap-2 hover:bg-primary/90 transition-colors">
                            <span class="material-symbols-outlined">add</span> Tambah Menu Dulu
                        </a>
                    </div>
                @else
                    <form method="POST" action="{{ route('seller.pesanan.store') }}" id="formPesanan" class="flex flex-col gap-5">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="flex flex-col gap-2">
                                <label for="nama_pembeli" class="font-label-md text-label-md text-on-surface">Nama Pembeli <span class="text-error">*</span></label>
                                <input id="nama_pembeli" name="nama_pembeli" type="text" required value="{{ old('nama_pembeli') }}" class="rounded-lg border border-outline-variant bg-surface-container-low px-4 py-2.5 font-body-md text-body-md focus:border-primary focus:ring-primary" placeholder="contoh: Ibu Sari">
                                @error('nama_pembeli') <span class="font-caption text-caption text-error">{{ $message }}</span> @enderror
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="no_wa" class="font-label-md text-label-md text-on-surface">No. WhatsApp</label>
                                <input id="no_wa" name="no_wa" type="text" value="{{ old('no_wa') }}" class="rounded-lg border border-outline-variant bg-surface-container-low px-4 py-2.5 font-body-md text-body-md focus:border-primary focus:ring-primary" placeholder="0812xxxxxxxx">
                                <p class="font-caption text-caption text-on-surface-variant">Dipakai untuk membuka chat WhatsApp pembeli.</p>
                                @error('no_wa') <span class="font-caption text-caption text-error">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <span class="font-label-md text-label-md text-on-surface">Menu Dipesan <span class="text-error">*</span></span>
                            <div id="itemRows" class="flex flex-col gap-3">
                                @foreach ($itemRows as $row)
                                    <div class="item-row grid grid-cols-1 sm:grid-cols-[1fr_auto_auto] gap-3 items-end">
                                        <div class="flex flex-col gap-1">
                                            <label class="sm:hidden font-caption text-caption text-on-surface-variant">Menu</label>
                                            <select name="items[{{ $loop->index }}][menu_id]" required class="item-menu rounded-lg border border-outline-variant bg-surface-container-low px-4 py-2.5 font-body-md text-body-md focus:border-primary focus:ring-primary">
                                                <option value="">-- Pilih menu --</option>
                                                @foreach ($menus as $menu)
                                                    <option value="{{ $menu->id }}" data-harga="{{ $menu->price }}" {{ (string) old("items.$loop->index.menu_id", $row['menu_id'] ?? '') === (string) $menu->id ? 'selected' : '' }}>{{ $menu->name }} &mdash; Rp {{ number_format($menu->price, 0, ',', '.') }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="flex flex-col gap-1 w-full sm:w-28">
                                            <label class="sm:hidden font-caption text-caption text-on-surface-variant">Jumlah</label>
                                            <input type="number" name="items[{{ $loop->index }}][qty]" min="1" max="999" value="{{ old("items.$loop->index.qty", $row['qty'] ?? 1) }}" class="item-qty rounded-lg border border-outline-variant bg-surface-container-low px-4 py-2.5 font-body-md text-body-md focus:border-primary focus:ring-primary">
                                        </div>
                                        <button type="button" onclick="hapusItemRow(this)" title="Hapus baris" class="w-10 h-10 flex items-center justify-center rounded-lg bg-surface-variant text-on-surface-variant hover:bg-error-container hover:text-on-error-container transition-colors">
                                            <span class="material-symbols-outlined text-[18px]">close</span>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            @error('items') <span class="font-caption text-caption text-error">{{ $message }}</span> @enderror
                            @error('items.*.menu_id') <span class="font-caption text-caption text-error">{{ $message }}</span> @enderror
                            @error('items.*.qty') <span class="font-caption text-caption text-error">{{ $message }}</span> @enderror
                            <div class="flex flex-wrap items-center justify-between gap-3">
                                <button type="button" onclick="tambahItemRow()" class="font-label-md text-label-md text-primary hover:underline flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[18px]">add</span> Tambah Baris Menu
                                </button>
                                <p class="font-label-md text-label-md text-on-surface">Total: <span id="totalPesanan" class="text-primary">Rp 0</span></p>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="catatan" class="font-label-md text-label-md text-on-surface">Catatan</label>
                            <textarea id="catatan" name="catatan" rows="2" class="rounded-lg border border-outline-variant bg-surface-container-low px-4 py-2.5 font-body-md text-body-md focus:border-primary focus:ring-primary" placeholder="contoh: ambil sendiri jam 17.00, level 2">{{ old('catatan') }}</textarea>
                            @error('catatan') <span class="font-caption text-caption text-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3 pt-2 border-t border-outline-variant">
                            <button type="submit" class="bg-primary text-on-primary px-6 py-3 rounded-lg font-label-md text-label-md flex items-center justify-center gap-2 hover:bg-primary/90 transition-colors">
                                <span class="material-symbols-outlined text-[18px]">save</span> Simpan Pesanan
                            </button>
                            <button type="reset" onclick="resetItemRows()" class="px-6 py-3 rounded-lg font-label-md text-label-md border border-outline-variant text-on-surface hover:bg-surface-container transition-colors">
                                Bersihkan
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </details>

        <!-- Filter -->
        <form method="GET" action="{{ route('seller.pesanan.index') }}" class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 flex flex-col gap-5">
            <div class="flex flex-col gap-3">
                <span class="font-label-md text-label-md text-on-surface">Status</span>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ request()->fullUrlWithQuery(['status' => null, 'page' => null]) }}" class="px-4 py-1.5 rounded-full font-label-md text-label-md transition-colors {{ $filterStatus === null ? 'bg-primary text-on-primary' : 'border border-outline-variant text-on-surface-variant hover:bg-surface-container' }}">Semua</a>
                    @foreach ($statuses as $value => $label)
                        <a href="{{ request()->fullUrlWithQuery(['status' => $value, 'page' => null]) }}" class="px-4 py-1.5 rounded-full font-label-md text-label-md transition-colors {{ $filterStatus === $value ? 'bg-primary text-on-primary' : 'border border-outline-variant text-on-surface-variant hover:bg-surface-container' }}">{{ $label }}</a>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="flex flex-col gap-2 lg:col-span-2">
                    <label for="q" class="font-label-md text-label-md text-on-surface">Cari</label>
                    <input id="q" name="q" type="search" value="{{ $search }}" class="rounded-lg border border-outline-variant bg-surface-container-low px-4 py-2.5 font-body-md text-body-md focus:border-primary focus:ring-primary" placeholder="Kode pesanan, nama, atau no. WA">
                </div>
                <div class="flex flex-col gap-2">
                    <label for="from" class="font-label-md text-label-md text-on-surface">Dari Tanggal</label>
                    <input id="from" name="from" type="date" value="{{ $from }}" class="rounded-lg border border-outline-variant bg-surface-container-low px-4 py-2.5 font-body-md text-body-md focus:border-primary focus:ring-primary">
                </div>
                <div class="flex flex-col gap-2">
                    <label for="to" class="font-label-md text-label-md text-on-surface">Sampai Tanggal</label>
                    <input id="to" name="to" type="date" value="{{ $to }}" class="rounded-lg border border-outline-variant bg-surface-container-low px-4 py-2.5 font-body-md text-body-md focus:border-primary focus:ring-primary">
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="submit" class="bg-primary text-on-primary px-6 py-2.5 rounded-lg font-label-md text-label-md flex items-center gap-2 hover:bg-primary/90 transition-colors">
                    <span class="material-symbols-outlined text-[18px]">filter_alt</span> Terapkan Filter
                </button>
                @if ($filterStatus || $search !== '' || $from || $to)
                    <a href="{{ route('seller.pesanan.index') }}" class="px-6 py-2.5 rounded-lg font-label-md text-label-md border border-outline-variant text-on-surface hover:bg-surface-container transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">restart_alt</span> Reset
                    </a>
                @endif
            </div>
        </form>

        <!-- Daftar Pesanan -->
        <div class="flex flex-col gap-stack-md">
            @if ($orders->isEmpty())
                <div class="bg-surface-container-lowest border border-dashed border-outline-variant rounded-xl p-stack-lg flex flex-col items-center justify-center text-center gap-4 min-h-[240px]">
                    <span class="material-symbols-outlined text-5xl text-on-surface-variant">receipt_long</span>
                    <div>
                        <h3 class="font-headline-md text-headline-md text-on-surface mb-1">Belum ada pesanan</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">
                            @if ($filterStatus || $search !== '' || $from || $to)
                                Tidak ada pesanan yang cocok dengan filter ini. Coba ubah kata kunci atau rentang tanggal.
                            @else
                                Catat pesanan pertama Anda lewat tombol "Catat Pesanan Baru" di atas.
                            @endif
                        </p>
                    </div>
                </div>
            @else
                @foreach ($orders as $order)
                    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm overflow-hidden">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 p-5 border-b border-outline-variant bg-surface-container-low">
                            <div class="flex flex-wrap items-center gap-3">
                                <span class="font-label-md text-label-md text-on-surface">{{ $order->kode }}</span>
                                <span class="text-xs font-bold uppercase tracking-wider px-2 py-1 rounded {{ $badge[$order->status] ?? 'bg-surface-variant text-on-surface-variant' }}">{{ $order->statusLabel() }}</span>
                                <span class="font-caption text-caption text-on-surface-variant">{{ $formatTanggal($order->created_at) }}</span>
                            </div>
                            <div class="font-headline-md text-headline-md text-primary whitespace-nowrap">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                        </div>

                        <div class="p-5 flex flex-col gap-4">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div>
                                    <p class="font-label-md text-label-md text-on-surface">{{ $order->nama_pembeli }}</p>
                                    @if ($order->no_wa)
                                        <p class="font-caption text-caption text-on-surface-variant">{{ $order->no_wa }}</p>
                                    @endif
                                </div>
                                @if ($order->no_wa)
                                    <a href="https://wa.me/{{ $order->no_wa }}?text={{ rawurlencode('Halo ' . $order->nama_pembeli . ', ini DapurWarga. Pesanan ' . $order->kode . ' Anda sudah kami terima. Total Rp ' . number_format($order->total, 0, ',', '.') . '.') }}" target="_blank" rel="noopener" class="bg-secondary-container text-on-secondary-container px-4 py-2 rounded-lg font-label-md text-label-md flex items-center justify-center gap-2 hover:brightness-95 transition-all">
                                        <span class="material-symbols-outlined text-[18px]">chat</span> Chat Pembeli
                                    </a>
                                @endif
                            </div>

                            <div class="border-t border-outline-variant pt-4 flex flex-col gap-2">
                                @foreach ($order->items as $item)
                                    <div class="flex items-center justify-between gap-4">
                                        <span class="font-body-md text-body-md text-on-surface">{{ $item->nama_menu }} <span class="text-on-surface-variant">&times; {{ $item->qty }}</span></span>
                                        <span class="font-label-md text-label-md text-on-surface-variant whitespace-nowrap">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </div>

                            @if ($order->catatan)
                                <div class="bg-surface-container-low border-l-4 border-outline-variant rounded-r-lg px-4 py-2">
                                    <p class="font-caption text-caption text-on-surface-variant">Catatan: {{ $order->catatan }}</p>
                                </div>
                            @endif

                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-4 border-t border-outline-variant">
                                <form method="POST" action="{{ route('seller.pesanan.status', $order) }}" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <label for="status-{{ $order->id }}" class="font-label-md text-label-md text-on-surface-variant">Ubah status</label>
                                    <select id="status-{{ $order->id }}" name="status" onchange="this.form.submit()" class="rounded-lg border border-outline-variant bg-surface-container-low px-3 py-2 font-body-md text-body-md focus:border-primary focus:ring-primary">
                                        @foreach ($statuses as $value => $label)
                                            <option value="{{ $value }}" {{ $order->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <noscript><button type="submit" class="font-label-md text-label-md text-primary hover:underline">Simpan</button></noscript>
                                </form>
                                <form method="POST" action="{{ route('seller.pesanan.destroy', $order) }}" onsubmit="return confirm('Hapus pesanan {{ $order->kode }}? Tindakan ini tidak dapat dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-label-md text-label-md text-on-surface-variant hover:text-error transition-colors flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[18px]">delete</span> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
</main>
<template id="tplItemRow">
    <div class="item-row grid grid-cols-1 sm:grid-cols-[1fr_auto_auto] gap-3 items-end">
        <div class="flex flex-col gap-1">
            <label class="sm:hidden font-caption text-caption text-on-surface-variant">Menu</label>
            <select name="items[__INDEX__][menu_id]" required class="item-menu rounded-lg border border-outline-variant bg-surface-container-low px-4 py-2.5 font-body-md text-body-md focus:border-primary focus:ring-primary">
                <option value="">-- Pilih menu --</option>
                @foreach ($menus as $menu)
                    <option value="{{ $menu->id }}" data-harga="{{ $menu->price }}">{{ $menu->name }} &mdash; Rp {{ number_format($menu->price, 0, ',', '.') }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex flex-col gap-1 w-full sm:w-28">
            <label class="sm:hidden font-caption text-caption text-on-surface-variant">Jumlah</label>
            <input type="number" name="items[__INDEX__][qty]" min="1" max="999" value="1" class="item-qty rounded-lg border border-outline-variant bg-surface-container-low px-4 py-2.5 font-body-md text-body-md focus:border-primary focus:ring-primary">
        </div>
        <button type="button" onclick="hapusItemRow(this)" title="Hapus baris" class="w-10 h-10 flex items-center justify-center rounded-lg bg-surface-variant text-on-surface-variant hover:bg-error-container hover:text-on-error-container transition-colors">
            <span class="material-symbols-outlined text-[18px]">close</span>
        </button>
    </div>
</template>
<script>
    const rupiah = (angka) => 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);

    function totalPesanan() {
        let total = 0;
        document.querySelectorAll('#itemRows .item-row').forEach((row) => {
            const opsi = row.querySelector('.item-menu').selectedOptions[0];
            const qty = parseInt(row.querySelector('.item-qty').value, 10) || 0;
            if (opsi && opsi.dataset.harga) {
                total += parseInt(opsi.dataset.harga, 10) * qty;
            }
        });
        document.getElementById('totalPesanan').textContent = rupiah(total);
    }

    function tambahItemRow() {
        const container = document.getElementById('itemRows');
        const index = container.querySelectorAll('.item-row').length;
        container.insertAdjacentHTML('beforeend', document.getElementById('tplItemRow').innerHTML.replaceAll('__INDEX__', index));
        totalPesanan();
    }

    function hapusItemRow(tombol) {
        const container = document.getElementById('itemRows');
        if (container.querySelectorAll('.item-row').length <= 1) {
            return;
        }
        tombol.closest('.item-row').remove();
        totalPesanan();
    }

    function resetItemRows() {
        setTimeout(totalPesanan, 0);
    }

    document.querySelectorAll('#itemRows').forEach((container) => {
        container.addEventListener('change', totalPesanan);
        container.addEventListener('input', totalPesanan);
    });

    totalPesanan();
</script>
</body></html>
