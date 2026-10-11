<?php

namespace App\Http\Controllers;

use App\Models\ServiceOption;
use Illuminate\Http\Request;

class ServiceOptionController extends Controller
{
    /**
     * Halaman untuk mengisi sendiri daftar kategori & satuan tarif.
     */
    public function index()
    {
        $options = auth()->user()->serviceOptions()
            ->orderBy('name')
            ->get();

        return view('layanan.opsi', [
            'categories' => $options->where('type', 'category')->values(),
            'units' => $options->where('type', 'unit')->values(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', 'in:category,unit'],
            'name' => ['required', 'string', 'max:50'],
        ]);

        $name = trim($data['name']);

        $existing = auth()->user()->serviceOptions()
            ->where('type', $data['type'])
            ->where('name', $name)
            ->first();

        if ($existing) {
            return back()->with('error', $data['type'] === 'category'
                ? 'Kategori tersebut sudah ada.'
                : 'Satuan tarif tersebut sudah ada.');
        }

        auth()->user()->serviceOptions()->create([
            'type' => $data['type'],
            'name' => $name,
        ]);

        return back()->with('success', $data['type'] === 'category'
            ? 'Kategori berhasil ditambahkan.'
            : 'Satuan tarif berhasil ditambahkan.');
    }

    public function destroy(ServiceOption $option)
    {
        abort_unless($option->user_id === auth()->id(), 403);
        $option->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }
}
