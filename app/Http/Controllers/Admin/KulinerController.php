<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Http\Request;

class KulinerController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));
        $query = Menu::with('seller')->latest();
        if ($search !== '') {
            $query->where(function ($inner) use ($search) {
                $inner->where('name', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhereHas('seller', fn ($q) => $q->where('nama_lapak', 'like', "%{$search}%")->orWhere('name', 'like', "%{$search}%"));
            });
        }
        $menus = $query->paginate(10)->withQueryString();
        $sellers = User::where('role', 'seller')->orderBy('name')->get();

        return view('admin.kuliner.index', compact('menus', 'sellers', 'search'));
    }

    public function toggle(Menu $menu)
    {
        $menu->update(['available' => ! $menu->available]);

        return back()->with('success', $menu->available ? 'Menu ditandai tersedia.' : 'Menu ditandai habis.');
    }

    public function toggleLapak(User $user)
    {
        if ($user->role !== 'seller') {
            return back()->withErrors(['user' => 'Bukan akun penjual.']);
        }
        $user->update(['lapak_buka' => ! $user->lapak_buka]);

        return back()->with('success', $user->lapak_buka ? 'Lapak dibuka.' : 'Lapak ditutup.');
    }

    public function destroy(Menu $menu)
    {
        (new \App\Http\Controllers\Seller\MenuController())->destroy($menu);
        return back()->with('success', 'Menu berhasil dihapus.');
    }
}