<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $menus = $user->menus()->latest()->get();

        $totalAktif = $menus->where('available', true)->count();
        $totalTerjual = $menus->sum('sold');
        $totalPorsi = $menus->sum('stock');

        return view('seller.dashboard', compact('menus', 'totalAktif', 'totalTerjual', 'totalPorsi'));
    }

    public function toggleLapak(Request $request)
    {
        $user = auth()->user();
        $user->update(['lapak_buka' => ! $user->lapak_buka]);

        return back()->with('success', $user->lapak_buka ? 'Lapak dibuka.' : 'Lapak ditutup.');
    }
}