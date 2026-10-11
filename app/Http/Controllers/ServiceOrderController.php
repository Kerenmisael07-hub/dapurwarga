<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceOrder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ServiceOrderController extends Controller
{
    /**
     * Daftar pesanan warga untuk layanan milik penyedia jasa yang login.
     */
    public function index(Request $request)
    {
        $filterStatus = $this->filterStatus($request);
        $search = trim((string) $request->query('q', ''));
        $from = $this->filterDate($request, 'from');
        $to = $this->filterDate($request, 'to');

        $baseQuery = ServiceOrder::where('user_id', auth()->id());
        $this->applyFilters($baseQuery, $filterStatus, $search, $from, $to);

        $orders = (clone $baseQuery)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $ringkasanQuery = ServiceOrder::where('user_id', auth()->id());
        $this->applyFilters($ringkasanQuery, $filterStatus, $search, $from, $to);

        $ringkasan = [
            'total_pesanan' => (clone $ringkasanQuery)->count(),
            'total_pendapatan' => (clone $ringkasanQuery)->where('status', '!=', ServiceOrder::STATUS_DIBATALKAN)->sum('total'),
            'perlu_diproses' => ServiceOrder::where('user_id', auth()->id())
                ->whereIn('status', [ServiceOrder::STATUS_BARU, ServiceOrder::STATUS_DIPROSES])
                ->count(),
        ];

        return view('layanan.pesanan', [
            'orders' => $orders,
            'services' => auth()->user()->services()->orderBy('name')->get(),
            'statuses' => ServiceOrder::statuses(),
            'filterStatus' => $filterStatus,
            'search' => $search,
            'from' => $from,
            'to' => $to,
            'ringkasan' => $ringkasan,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'service_id' => ['required', 'integer', 'exists:services,id'],
            'nama_pelanggan' => ['required', 'string', 'max:255'],
            'no_wa' => ['nullable', 'string', 'max:30'],
            'jadwal' => ['nullable', 'date'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        $service = Service::where('user_id', auth()->id())->find($data['service_id']);

        if (! $service) {
            return back()->withErrors(['service_id' => 'Layanan yang dipilih tidak valid.'])->withInput();
        }

        $total = $service->price;

        $order = ServiceOrder::create([
            'user_id' => auth()->id(),
            'service_id' => $service->id,
            'kode' => $this->nextKode(),
            'nama_pelanggan' => $data['nama_pelanggan'],
            'no_wa' => ServiceOrder::normalizeWa($data['no_wa'] ?? null),
            'layanan' => $service->name,
            'harga' => $service->price,
            'qty' => 1,
            'total' => $total,
            'status' => ServiceOrder::STATUS_BARU,
            'jadwal' => $data['jadwal'] ?? null,
            'catatan' => $data['catatan'] ?? null,
        ]);

        return redirect()
            ->route('layanan.pesanan.index')
            ->with('success', 'Pesanan '.$order->kode.' berhasil dicatat.');
    }

    public function updateStatus(Request $request, ServiceOrder $order)
    {
        $this->authorizeOrder($order);

        $data = $request->validate([
            'status' => ['required', 'in:'.implode(',', array_keys(ServiceOrder::statuses()))],
        ]);

        $order->update(['status' => $data['status']]);

        return back()->with('success', 'Status pesanan '.$order->kode.' diubah menjadi '.$order->fresh()->statusLabel().'.');
    }

    public function destroy(ServiceOrder $order)
    {
        $this->authorizeOrder($order);

        $kode = $order->kode;
        $order->delete();

        return back()->with('success', 'Pesanan '.$kode.' berhasil dihapus.');
    }

    protected function applyFilters(Builder $query, ?string $status, string $search, ?string $from, ?string $to): void
    {
        if ($status) {
            $query->where('status', $status);
        }

        if ($search !== '') {
            $query->where(function (Builder $inner) use ($search) {
                $inner->where('kode', 'like', '%'.$search.'%')
                    ->orWhere('nama_pelanggan', 'like', '%'.$search.'%')
                    ->orWhere('layanan', 'like', '%'.$search.'%')
                    ->orWhere('no_wa', 'like', '%'.$search.'%');
            });
        }

        if ($from) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to) {
            $query->whereDate('created_at', '<=', $to);
        }
    }

    protected function nextKode(): string
    {
        $prefix = 'LW'.now()->format('Ymd');
        $terakhir = ServiceOrder::where('kode', 'like', $prefix.'%')
            ->orderByDesc('kode')
            ->value('kode');

        $urutan = $terakhir ? ((int) substr($terakhir, -3)) + 1 : 1;

        do {
            $kode = $prefix.str_pad((string) $urutan, 3, '0', STR_PAD_LEFT);
            $urutan++;
        } while (ServiceOrder::where('kode', $kode)->exists());

        return $kode;
    }

    protected function filterStatus(Request $request): ?string
    {
        $status = $request->query('status');
        $status = is_string($status) ? $status : '';

        return array_key_exists($status, ServiceOrder::statuses()) ? $status : null;
    }

    protected function filterDate(Request $request, string $key): ?string
    {
        $value = $request->query($key);
        $value = is_string($value) ? trim($value) : '';

        if ($value === '' || ! preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            return null;
        }

        return $value;
    }

    protected function authorizeOrder(ServiceOrder $order): void
    {
        abort_unless($order->user_id === auth()->id(), 403);
    }
}
