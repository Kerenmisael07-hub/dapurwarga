<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - {{ config('app.name', 'Dapur Warga') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    <style>
        .role-card:has(input:checked) {
            border-color: #f97316;
            background-color: #fff7ed;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Register</h1>
                <p class="text-gray-500 mt-1">Buat akun baru</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4 mb-6 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}">
                @csrf

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Daftar Sebagai</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="role-card relative cursor-pointer rounded-lg border-2 border-gray-200 p-3 text-center transition hover:border-orange-300">
                            <input type="radio" name="role" value="seller" class="sr-only role-input" {{ old('role', 'seller') === 'seller' ? 'checked' : '' }} onchange="toggleLapakFields()">
                            <span class="text-sm font-semibold text-gray-700">Seller</span>
                            <p class="text-xs text-gray-400 mt-1">Jual makanan</p>
                        </label>
                        <label class="role-card relative cursor-pointer rounded-lg border-2 border-gray-200 p-3 text-center transition hover:border-orange-300">
                            <input type="radio" name="role" value="layanan" class="sr-only role-input" {{ old('role') === 'layanan' ? 'checked' : '' }} onchange="toggleLapakFields()">
                            <span class="text-sm font-semibold text-gray-700">Layanan</span>
                            <p class="text-xs text-gray-400 mt-1">Buka jasa layanan</p>
                        </label>
                    </div>
                </div>

                <div id="lapak-fields">
                    <div class="mb-5">
                        <label for="nama_lapak" class="block text-sm font-medium text-gray-700 mb-1">Nama Lapak</label>
                        <input
                            type="text"
                            id="nama_lapak"
                            name="nama_lapak"
                            value="{{ old('nama_lapak') }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                            placeholder="contoh: Lapak Bu Siti"
                        >
                    </div>

                    <div class="mb-5">
                        <label for="no_wa" class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp (untuk menerima pesanan)</label>
                        <input
                            type="text"
                            id="no_wa"
                            name="no_wa"
                            value="{{ old('no_wa') }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                            placeholder="contoh: 081234567890"
                        >
                    </div>
                </div>

                <div class="mb-5">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                        placeholder="Nama lengkap"
                    >
                </div>

                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                        placeholder="email@contoh.com"
                    >
                </div>

                <div class="mb-5">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                        placeholder="Minimal 8 karakter"
                    >
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                        placeholder="Ulangi password"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2.5 rounded-lg transition"
                >
                    Register
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-orange-500 hover:text-orange-600 font-medium">Login</a>
            </p>
        </div>
    </div>

<script>
        function toggleLapakFields() {
            const isLayanan = document.querySelector('input[name="role"]:checked')?.value === 'layanan';
            document.getElementById('lapak-fields').style.display = isLayanan ? 'none' : 'block';
        }
        toggleLapakFields();
    </script>
</body>
</html>
