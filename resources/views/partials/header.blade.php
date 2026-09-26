<header class="sticky top-0 z-50 border-b border-outline-variant bg-surface/95 backdrop-blur-nav">
    <div class="mx-auto flex w-full max-w-container-max items-center justify-between px-margin-mobile md:px-gutter py-4">
        <a class="nav-link flex items-center text-xl font-bold text-primary" href="{{ url('/') }}">DapurWarga</a>

        <nav class="hidden items-center gap-7 md:flex">
            <a href="{{ url('/') }}" class="nav-link font-semibold {{ ($active ?? 'beranda') === 'beranda' ? 'nav-link-active text-primary' : 'text-on-surface-variant' }}">Beranda</a>
            <a href="{{ url('/jadwal-kuliner') }}" class="nav-link font-semibold {{ ($active ?? 'beranda') === 'jadwal-kuliner' ? 'nav-link-active text-primary' : 'text-on-surface-variant' }}">Jadwal Kuliner</a>
            <a href="{{ url('/layanan') }}" class="nav-link font-semibold {{ ($active ?? 'beranda') === 'layanan' ? 'nav-link-active text-primary' : 'text-on-surface-variant' }}">Layanan</a>
            <a href="{{ url('/info-rt') }}" class="nav-link font-semibold {{ ($active ?? 'beranda') === 'info-rt' ? 'nav-link-active text-primary' : 'text-on-surface-variant' }}">Info RT</a>
        </nav>

        <div class="flex items-center gap-4">
            <button aria-label="Cari" class="press-anim flex items-center text-on-surface transition-colors hover:text-primary">
                <span class="material-symbols-outlined">search</span>
            </button>

            <div class="hidden items-center gap-3 md:flex">
                <a href="{{ route('login') }}" class="press-anim rounded border border-outline-variant px-4 py-2 font-semibold transition-colors hover:bg-gray-100">Login</a>
            </div>

            <button aria-label="Menu" class="press-anim text-on-surface md:hidden" onclick="document.getElementById('mobileMenu').classList.toggle('hidden')">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
    </div>
</header>

<div id="mobileMenu" class="hidden border-b border-outline-variant bg-surface px-margin-mobile md:px-gutter py-4 md:hidden">
    <nav class="flex flex-col gap-3">
        <a href="{{ url('/') }}" class="nav-link font-semibold {{ ($active ?? 'beranda') === 'beranda' ? 'nav-link-active text-primary' : 'text-on-surface-variant' }}">Beranda</a>
        <a href="{{ url('/jadwal-kuliner') }}" class="nav-link font-semibold {{ ($active ?? 'beranda') === 'jadwal-kuliner' ? 'nav-link-active text-primary' : 'text-on-surface-variant' }}">Jadwal Kuliner</a>
        <a href="{{ url('/layanan') }}" class="nav-link font-semibold {{ ($active ?? 'beranda') === 'layanan' ? 'nav-link-active text-primary' : 'text-on-surface-variant' }}">Layanan</a>
        <a href="{{ url('/info-rt') }}" class="nav-link font-semibold {{ ($active ?? 'beranda') === 'info-rt' ? 'nav-link-active text-primary' : 'text-on-surface-variant' }}">Info RT</a>

        <hr class="border-outline-variant">

        <a href="{{ route('login') }}" class="press-anim text-on-surface-variant hover:text-primary">Login</a>
    </nav>
</div>
