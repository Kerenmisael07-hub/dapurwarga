@php
    $navItems = [
        'dashboard' => ['route' => 'admin.dashboard', 'icon' => 'dashboard', 'label' => 'Dashboard'],
        'pengguna' => ['route' => 'admin.pengguna.index', 'icon' => 'group', 'label' => 'Pengguna & Peran'],
        'kuliner' => ['route' => 'admin.kuliner.index', 'icon' => 'restaurant_menu', 'label' => 'Menu Kuliner & Lapak'],
        'layanan' => ['route' => 'admin.layanan.index', 'icon' => 'home_repair_service', 'label' => 'Layanan Jasa'],
        'info-rt' => ['route' => 'admin.info-rt.index', 'icon' => 'info', 'label' => 'Info RT'],
    ];
    $navTitle = $navItems[$active ?? 'dashboard']['label'] ?? 'Dashboard Admin';
@endphp
@include('partials.dashboard-header', ['title' => $navTitle, 'mobileNavId' => 'mobileNav', 'brandOnDesktop' => true])
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
