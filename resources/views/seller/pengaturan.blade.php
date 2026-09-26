<!DOCTYPE html>
<html lang="id"><head>
@include('seller.partials.head', ['title' => 'Pengaturan'])
</head>
<body class="bg-surface text-on-surface h-screen flex overflow-hidden">
@include('seller.partials.sidebar', ['active' => 'pengaturan'])
<!-- Main Content -->
<main class="flex-1 flex flex-col h-full overflow-hidden bg-background">
@include('seller.partials.nav', ['active' => 'pengaturan'])
    <div class="flex-1 overflow-y-auto p-margin-mobile md:p-gutter">
        <div class="max-w-3xl mx-auto space-y-stack-lg pb-section-gap">
            <div>
                <a href="{{ route('seller.dashboard') }}" class="font-label-md text-label-md text-on-surface-variant hover:text-primary flex items-center gap-1 mb-4">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span> Kembali ke Dasbor
                </a>
                <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary">Pengaturan</h1>
                <p class="font-body-md text-body-md text-on-surface-variant mt-1">Kelola data lapak yang tampil di halaman publik dan akun Anda.</p>
            </div>

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

            <form method="POST" action="{{ route('seller.pengaturan.update') }}" enctype="multipart/form-data" class="flex flex-col gap-stack-lg">
                @csrf
                @method('PUT')

                <!-- Data Lapak -->
                <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 flex flex-col gap-5">
                    <div>
                        <h2 class="font-headline-md text-headline-md text-on-surface flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">storefront</span>
                            Data Lapak
                        </h2>
                        <p class="font-caption text-caption text-on-surface-variant mt-1">Informasi ini tampil di beranda dan jadwal kuliner DapurWarga.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="flex flex-col gap-2">
                            <label for="nama_lapak" class="font-label-md text-label-md text-on-surface">Nama Lapak <span class="text-error">*</span></label>
                            <input id="nama_lapak" name="nama_lapak" type="text" required value="{{ old('nama_lapak', $user->nama_lapak) }}" class="rounded-lg border border-outline-variant bg-surface-container-low px-4 py-2.5 font-body-md text-body-md focus:border-primary focus:ring-primary" placeholder="contoh: Dapur Ibu Sari">
                            @error('nama_lapak') <span class="font-caption text-caption text-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="no_wa" class="font-label-md text-label-md text-on-surface">No. WhatsApp <span class="text-error">*</span></label>
                            <input id="no_wa" name="no_wa" type="text" required value="{{ old('no_wa', $user->no_wa) }}" class="rounded-lg border border-outline-variant bg-surface-container-low px-4 py-2.5 font-body-md text-body-md focus:border-primary focus:ring-primary" placeholder="0812xxxxxxxx">
                            <p class="font-caption text-caption text-on-surface-variant">Dipakai tombol pemesanan di halaman publik.</p>
                            @error('no_wa') <span class="font-caption text-caption text-error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-between gap-4 pt-2 border-t border-outline-variant">
                        <div>
                            <p class="font-label-md text-label-md text-on-surface">Status Lapak</p>
                            <p class="font-caption text-caption text-on-surface-variant mt-1">
                                {{ $user->lapak_buka ? 'Lapak Anda terbuka dan menerima pesanan.' : 'Lapak Anda ditutup dan tidak menerima pesanan.' }}
                            </p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                            <input type="checkbox" name="lapak_buka" value="1" class="sr-only peer" {{ old('lapak_buka', $user->lapak_buka) ? 'checked' : '' }}>
                            <div class="w-14 h-7 bg-outline-variant peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:border-gray-300 after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-secondary"></div>
                        </label>
                    </div>
                </div>

                <!-- Profil -->
                <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 flex flex-col gap-5">
                    <div>
                        <h2 class="font-headline-md text-headline-md text-on-surface flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">person</span>
                            Profil Penjual
                        </h2>
                        <p class="font-caption text-caption text-on-surface-variant mt-1">Nama Anda tampil sebagai pemilik lapak di halaman menu.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="flex flex-col gap-2">
                            <label for="name" class="font-label-md text-label-md text-on-surface">Nama Lengkap <span class="text-error">*</span></label>
                            <input id="name" name="name" type="text" required value="{{ old('name', $user->name) }}" class="rounded-lg border border-outline-variant bg-surface-container-low px-4 py-2.5 font-body-md text-body-md focus:border-primary focus:ring-primary" placeholder="contoh: Sari Wulandari">
                            @error('name') <span class="font-caption text-caption text-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="email" class="font-label-md text-label-md text-on-surface">Email <span class="text-error">*</span></label>
                            <input id="email" name="email" type="email" required value="{{ old('email', $user->email) }}" class="rounded-lg border border-outline-variant bg-surface-container-low px-4 py-2.5 font-body-md text-body-md focus:border-primary focus:ring-primary" placeholder="nama@email.com">
                            @error('email') <span class="font-caption text-caption text-error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center gap-5 pt-5 border-t border-outline-variant">
                        <div class="shrink-0">
                            <div id="foto-preview" class="w-28 h-28 rounded-full overflow-hidden border border-outline-variant bg-surface-container-low flex items-center justify-center">
                                @if ($user->foto_profile)
                                    <img src="{{ $user->foto_profile }}" alt="Foto profil" class="w-full h-full object-cover">
                                @else
                                    <div id="foto-placeholder" class="w-full h-full flex flex-col items-center justify-center gap-1 text-on-surface-variant">
                                        <span class="material-symbols-outlined text-4xl">account_circle</span>
                                        <span class="font-caption text-caption">Belum ada foto</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 flex-1 min-w-0">
                            <label for="foto" class="font-label-md text-label-md text-on-surface">Foto Profil</label>
                            <input id="foto" name="foto" type="file" accept="image/*" onchange="previewFoto(this)" class="block w-full text-sm text-on-surface border border-outline-variant rounded-lg bg-surface-container-low file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:bg-primary file:text-on-primary file:font-label-md file:text-label-md hover:file:bg-primary/90 cursor-pointer transition-colors">
                            <p class="font-caption text-caption text-on-surface-variant">
                                Format bebas (JPG, PNG, WEBP, GIF, BMP, dan lainnya). {{ \App\Rules\GambarUpload::infoUkuran() }}. Foto otomatis dipotong jadi persegi (1:1) dan tampil sebagai lingkaran di beranda serta jadwal kuliner.
                            </p>
                            @error('foto') <span class="font-caption text-caption text-error">{{ $message }}</span> @enderror
                            @if ($user->foto_profile)
                                <label class="flex items-center gap-2 cursor-pointer mt-1">
                                    <input type="checkbox" name="hapus_foto" value="1" class="w-4 h-4 accent-error" {{ old('hapus_foto') ? 'checked' : '' }}>
                                    <span class="font-caption text-caption text-on-surface-variant">Hapus foto profil ini</span>
                                </label>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Keamanan -->
                <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 flex flex-col gap-5">
                    <div>
                        <h2 class="font-headline-md text-headline-md text-on-surface flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">lock</span>
                            Ganti Password
                        </h2>
                        <p class="font-caption text-caption text-on-surface-variant mt-1">Kosongkan kedua kolom ini jika Anda tidak ingin mengganti password.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="flex flex-col gap-2">
                            <label for="password" class="font-label-md text-label-md text-on-surface">Password Baru</label>
                            <input id="password" name="password" type="password" autocomplete="new-password" class="rounded-lg border border-outline-variant bg-surface-container-low px-4 py-2.5 font-body-md text-body-md focus:border-primary focus:ring-primary" placeholder="Minimal 8 karakter">
                            @error('password') <span class="font-caption text-caption text-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="password_confirmation" class="font-label-md text-label-md text-on-surface">Ulangi Password Baru</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" class="rounded-lg border border-outline-variant bg-surface-container-low px-4 py-2.5 font-body-md text-body-md focus:border-primary focus:ring-primary" placeholder="Ketik ulang password">
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="submit" class="bg-primary text-on-primary px-6 py-3 rounded-lg font-label-md text-label-md flex items-center justify-center gap-2 hover:bg-primary/90 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">save</span> Simpan Pengaturan
                    </button>
                    <a href="{{ route('seller.dashboard') }}" class="px-6 py-3 rounded-lg font-label-md text-label-md border border-outline-variant text-on-surface hover:bg-surface-container transition-colors text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>
<script>
    function previewFoto(input) {
        const box = document.getElementById('foto-preview');
        if (!input.files || !input.files[0]) {
            return;
        }
        box.innerHTML = '<img src="' + URL.createObjectURL(input.files[0]) + '" alt="Preview foto profil" class="w-full h-full object-cover">';
    }
</script>
</body></html>
