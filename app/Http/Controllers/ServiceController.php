<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Rules\GambarUpload;
use App\Support\HandlesSquareImages;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use HandlesSquareImages;
    /**
     * Katalog publik (DapurWarga): hanya menampilkan layanan aktif,
     * lengkap dengan filter kategori dan pencarian.
     */
    public function index(Request $request)
    {
        $category = $request->query('category');
        $search = $request->query('search');

        $services = Service::with('seller')
            ->where('status', 'tersedia')
            ->when($category, fn (Builder $query) => $query->where('category', $category))
            ->when($search, function (Builder $query) use ($search) {
                $query->where(function (Builder $inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        $categories = Service::where('status', 'tersedia')
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('layanan.index', [
            'active' => 'layanan',
            'services' => $services,
            'categories' => $categories,
            'selectedCategory' => $category,
            'search' => $search,
        ]);
    }

    /**
     * Dashboard penyedia jasa: daftar layanan milik user yang login.
     */
    public function dashboard()
    {
        $services = auth()->user()->services()->latest()->get();

        $totalLayanan = $services->count();
        $totalTersedia = $services->where('status', 'tersedia')->count();
        $totalSibuk = $services->where('status', 'sibuk')->count();
        $totalKategori = $services->pluck('category')->unique()->count();

        return view('layanan.dashboard', [
            'services' => $services,
            'totalLayanan' => $totalLayanan,
            'totalTersedia' => $totalTersedia,
            'totalSibuk' => $totalSibuk,
            'totalKategori' => $totalKategori,
        ]);
    }

    public function create()
    {
        return view('layanan.form', ['service' => null] + $this->optionLists());
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['user_id'] = auth()->id();

        if (empty($data['whatsapp_number'])) {
            $data['whatsapp_number'] = auth()->user()->no_wa;
        }

        unset($data['foto']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $this->storeSquareImage($request->file('foto'), 'uploads/layanan', 1000);
        }

        Service::create($data);

        return redirect()->route('layanan.dashboard')->with('success', 'Layanan jasa berhasil ditambahkan.');
    }

    public function edit(Service $service)
    {
        $this->authorizeService($service);

        return view('layanan.form', ['service' => $service] + $this->optionLists());
    }

    public function update(Request $request, Service $service)
    {
        $this->authorizeService($service);

        $data = $this->validated($request);
        unset($data['foto']);

        $oldPhoto = $service->getRawOriginal('foto');

        if ($request->hasFile('foto')) {
            $data['foto'] = $this->storeSquareImage($request->file('foto'), 'uploads/layanan', 1000);
        }

        $service->update($data);

        if ($request->hasFile('foto') && $oldPhoto && $oldPhoto !== $service->getRawOriginal('foto')) {
            $this->deleteStoredImage($oldPhoto);
        }

        return redirect()->route('layanan.dashboard')->with('success', 'Layanan jasa berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        $this->authorizeService($service);
        $this->deleteStoredImage($service->getRawOriginal('foto'));
        $service->delete();

        return back()->with('success', 'Layanan jasa berhasil dihapus.');
    }

    public function toggleStatus(Service $service)
    {
        $this->authorizeService($service);
        $service->update(['status' => $service->status === 'tersedia' ? 'sibuk' : 'tersedia']);

        return back()->with('success', $service->status === 'tersedia' ? 'Layanan ditandai tersedia.' : 'Layanan ditandai sedang sibuk.');
    }

    protected function authorizeService(Service $service): void
    {
        abort_unless($service->user_id === auth()->id(), 403);
    }

    /**
     * Gabungan pilihan default + kategori & satuan tarif yang diisi sendiri
     * oleh penyedia jasa, dipakai untuk datalist pada form layanan.
     */
    protected function optionLists(): array
    {
        $defaultCategories = [
            'Pertukangan',
            'Plumbing & Pipa',
            'Mesin & Pompa',
            'Konstruksi Ringan',
            'Perbaikan Rumah',
            'Pendidikan & Les',
            'Rumah Tangga',
            'Kecantikan',
            'Kesehatan',
        ];

        $defaultUnits = ['Panggilan', 'Jam', 'Unit', 'Titik', 'Sesi', 'Hari'];

        $custom = auth()->user()->serviceOptions()->get();

        return [
            'categories' => collect($defaultCategories)
                ->merge($custom->where('type', 'category')->pluck('name'))
                ->unique()
                ->values(),
            'units' => collect($defaultUnits)
                ->merge($custom->where('type', 'unit')->pluck('name'))
                ->unique()
                ->values(),
        ];
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:50'],
            'price' => ['required', 'integer', 'min:0'],
            'price_unit' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'in:tersedia,sibuk'],
            'whatsapp_number' => ['nullable', 'string', 'max:20'],
            'foto' => ['nullable', new GambarUpload],
        ]);
    }
}
