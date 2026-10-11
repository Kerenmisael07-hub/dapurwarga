@php
    $navItems = [
        'dashboard' => ['route' => 'seller.dashboard', 'icon' => 'storefront', 'label' => 'Beranda Lapak'],
        'menu' => ['route' => 'seller.menu.create', 'icon' => 'add_circle', 'label' => 'Tambah Menu Baru'],
        'pesanan' => ['route' => 'seller.pesanan.index', 'icon' => 'receipt_long', 'label' => 'Riwayat Pesanan'],
        'pengaturan' => ['route' => 'seller.pengaturan.edit', 'icon' => 'settings', 'label' => 'Pengaturan'],
    ];
    $navTitle = $navItems[$active ?? 'dashboard']['label'] ?? 'Dashboard';
@endphp
@include('partials.dashboard-header', ['title' => $navTitle, 'mobileNavId' => 'mobileNav'])
<div id="mobileNav" class="md:hidden hidden bg-surface-container-lowest border-b border-outline-variant px-margin-mobile py-4 flex flex-col gap-2">
    @foreach ($navItems as $key => $item)
        <a class="flex items-center gap-3 px-4 py-3 rounded-lg font-label-md text-label-md {{ ($active ?? 'dashboard') === $key ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:bg-surface-container' }}" href="{{ route($item['route']) }}">
            <span class="material-symbols-outlined">{{ $item['icon'] }}</span> {{ $item['label'] }}
        </a>
    @endforeach

    <form method="POST" action="{{ route('logout') }}" class="mt-2 border-t border-outline-variant pt-2">
        @csrf
        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-container hover:text-error transition-colors">
            <span class="material-symbols-outlined">logout</span> Keluar
        </button>
    </form>
</div>
