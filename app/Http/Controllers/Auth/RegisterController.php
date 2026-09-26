<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:seller,layanan'],
            'nama_lapak' => ['nullable', 'string', 'max:255'],
            'no_wa' => ['nullable', 'string', 'max:20'],
        ]);

        $role = $validated['role'];

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $role,
            'nama_lapak' => $role === 'seller' ? ($validated['nama_lapak'] ?? null) : null,
            'no_wa' => $role === 'seller' ? ($validated['no_wa'] ?? null) : null,
        ]);

        Auth::login($user);

        if ($role === 'layanan') {
            return redirect()->intended('/layanan/dashboard');
        }

        return redirect()->intended('/seller/dashboard');
    }
}
