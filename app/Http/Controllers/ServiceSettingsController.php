<?php

namespace App\Http\Controllers;

use App\Rules\GambarUpload;
use App\Support\HandlesSquareImages;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceSettingsController extends Controller
{
    use HandlesSquareImages;

    public function edit()
    {
        return view('layanan.pengaturan', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'nama_lapak' => ['required', 'string', 'max:255'],
            'no_wa' => ['required', 'string', 'max:30'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'foto' => ['nullable', new GambarUpload],
            'hapus_foto' => ['nullable', 'boolean'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'email.unique' => 'Email ini sudah dipakai akun lain.',
        ]);

        unset($data['password'], $data['password_confirmation'], $data['foto'], $data['hapus_foto']);

        $oldPhoto = $user->getRawOriginal('foto_profile');

        if ($request->boolean('hapus_foto')) {
            $this->deleteStoredImage($oldPhoto);
            $data['foto_profile'] = null;
        }

        if ($request->hasFile('foto')) {
            $data['foto_profile'] = $this->storeSquareImage($request->file('foto'), 'uploads/profil', 600);
        }

        $user->fill($data);

        if ($request->filled('password')) {
            $user->password = $request->input('password');
        }

        $user->save();

        if ($request->hasFile('foto') && $oldPhoto && $oldPhoto !== $user->getRawOriginal('foto_profile')) {
            $this->deleteStoredImage($oldPhoto);
        }

        return redirect()
            ->route('layanan.pengaturan.edit')
            ->with('success', 'Pengaturan berhasil disimpan.');
    }
}
