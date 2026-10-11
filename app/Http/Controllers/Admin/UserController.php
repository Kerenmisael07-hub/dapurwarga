<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->query('role');
        $search = trim((string) $request->query('q', ''));

        $query = User::query()->orderByDesc('id');
        if ($role && in_array($role, ['admin', 'superadmin', 'seller', 'layanan'], true)) {
            $query->where('role', $role);
        }
        if ($search !== '') {
            $query->where(function ($inner) use ($search) {
                $inner->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(10)->withQueryString();
        $roles = ['superadmin', 'admin', 'seller', 'layanan'];

        return view('admin.users.index', compact('users', 'roles', 'role', 'search'));
    }

    public function update(Request $request, User $pengguna)
    {
        $data = $request->validate([
            'role' => ['required', Rule::in(['superadmin', 'admin', 'seller', 'layanan'])],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if ($pengguna->id === auth()->id()) {
            return back()->withErrors(['role' => 'Tidak boleh mengubah peran akun sendiri.']);
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $pengguna->update($data);

        return back()->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function toggleAktif(User $pengguna)
    {
        if ($pengguna->id === auth()->id()) {
            return back()->withErrors(['user' => 'Tidak boleh menonaktifkan akun sendiri.']);
        }

        $pengguna->update(['is_active' => ! $pengguna->is_active]);

        return back()->with('success', $pengguna->is_active ? 'Akun diaktifkan.' : 'Akun dinonaktifkan.');
    }

    public function destroy(User $pengguna)
    {
        if ($pengguna->id === auth()->id()) {
            return back()->withErrors(['user' => 'Tidak boleh menghapus akun sendiri.']);
        }

        $pengguna->delete();

        return back()->with('success', 'Pengguna berhasil dihapus.');
    }
}