<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));
        $query = Service::with('seller')->latest();
        if ($search !== '') {
            $query->where(function ($inner) use ($search) {
                $inner->where('name', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhereHas('seller', fn ($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }
        $services = $query->paginate(10)->withQueryString();

        return view('admin.layanan.index', compact('services', 'search'));
    }

    public function toggle(Service $service)
    {
        $service->update(['status' => $service->status === 'tersedia' ? 'sibuk' : 'tersedia']);

        return back()->with('success', $service->status === 'tersedia' ? 'Layanan ditandai tersedia.' : 'Layanan ditandai sibuk.');
    }

    public function destroy(Service $service)
    {
        (new \App\Http\Controllers\ServiceController())->destroy($service);

        return back()->with('success', 'Layanan berhasil dihapus.');
    }
}