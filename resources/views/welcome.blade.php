<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DapurWarga</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#070235',
                        surface: '#f7f9fb',
                        'on-surface': '#191c1e',
                        'on-surface-variant': '#47464f',
                        'outline-variant': '#c8c5d0'
                    }
                }
            }
        };
    </script>
</head>
<body class="bg-surface text-on-surface antialiased">
    <header class="sticky top-0 z-50 border-b border-outline-variant bg-surface/95 backdrop-blur-md">
        <div class="mx-auto flex w-full max-w-[1280px] items-center justify-between px-6 py-4">
            <a class="flex items-center text-xl font-bold text-primary" href="#">DapurWarga</a>

            <nav class="hidden items-center gap-7 md:flex">
                <a class="border-b-2 border-primary pb-1 font-semibold text-primary" href="#">Beranda</a>
                <a class="text-on-surface-variant transition-colors hover:text-primary" href="#">Jadwal Kuliner</a>
                <a class="text-on-surface-variant transition-colors hover:text-primary" href="#">Info RT</a>
            </nav>

            <div class="flex items-center gap-4">
                <button aria-label="Search" class="flex items-center text-on-surface transition-colors hover:text-primary">
                    <span class="material-symbols-outlined">search</span>
                </button>
                <div class="hidden items-center gap-2 md:flex">
                    @auth
                        <a href="{{ url('/seller/dashboard') }}" class="rounded border border-outline-variant px-4 py-2 font-semibold transition-colors hover:bg-gray-100">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="rounded bg-primary px-4 py-2 font-semibold text-white transition-colors hover:bg-[#1e1b4b]">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="rounded border border-outline-variant px-4 py-2 font-semibold transition-colors hover:bg-gray-100">Login</a>
                        <a href="{{ route('register') }}" class="rounded bg-primary px-4 py-2 font-semibold text-white transition-colors hover:bg-[#1e1b4b]">Daftar Lapak</a>
                    @endauth
                </div>
                <button aria-label="Menu" class="text-on-surface md:hidden" onclick="document.getElementById('mobileMenu').classList.toggle('hidden')">
                    <span class="material-symbols-outlined">menu</span>
                </button>
            </div>
        </div>
    </header>

    <div id="mobileMenu" class="hidden border-b border-outline-variant bg-surface px-6 py-4 md:hidden">
        <nav class="flex flex-col gap-3">
            <a class="font-semibold text-primary" href="#">Beranda</a>
            <a class="text-on-surface-variant hover:text-primary" href="#">Jadwal Kuliner</a>
            <a class="text-on-surface-variant hover:text-primary" href="#">Info RT</a>
            <hr class="border-outline-variant">
            @auth
                <a href="{{ url('/seller/dashboard') }}" class="text-on-surface-variant hover:text-primary">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-left text-on-surface-variant hover:text-primary">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-on-surface-variant hover:text-primary">Login</a>
                <a href="{{ route('register') }}" class="text-on-surface-variant hover:text-primary">Daftar Lapak</a>
            @endauth
        </nav>
    </div>
</body>
</html>
