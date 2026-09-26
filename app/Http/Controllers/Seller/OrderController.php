<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $filterStatus = $this->filterStatus($request);
        $search = trim((string) $request->query('q', ''));
        $from = $this->filterDate($request, 'from');
        $to = $this->filterDate($request, 'to');

        $baseQuery = Order::where('user_id', auth()->id());

        $this->applyFilters($baseQuery, $filterStatus, $search, $from, $to);

        $orders = (clone $baseQuery)
            ->with('items')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $ringkasanQuery = Order::where('user_id', auth()->id());
        $this->applyFilters($ringkasanQuery, $filterStatus, $search, $from, $to);

        $ringkasan = [
            'total_pesanan' => (clone $ringkasanQuery)->count(),
            'total_pendapatan' => (clone $ringkasanQuery)->where('status', '!=', Order::STATUS_DIBATALKAN)->sum('total'),
            'perlu_diproses' => Order::where('user_id', auth()->id())->whereIn('status', [Order::STATUS_BARU, Order::STATUS_DIPROSES])->count(),
        ];

        return view('seller.pesanan', [
            'orders' => $orders,
            'menus' => auth()->user()->menus()->orderBy('name')->get(),
            'statuses' => Order::statuses(),
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
            'nama_pembeli' => ['required', 'string', 'max:255'],
            'no_wa' => ['nullable', 'string', 'max:30'],
            'catatan' => ['nullable', 'string', 'max:1000'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.menu_id' => ['required', 'integer', 'exists:menus,id'],
            'items.*.qty' => ['required', 'integer', 'min:1', 'max:999'],
        ]);

        $menus = Menu::where('user_id', auth()->id())
            ->whereIn('id', array_column($data['items'], 'menu_id'))
            ->get()
            ->keyBy('id');

        if ($menus->count() !== count(array_unique(array_column($data['items'], 'menu_id')))) {
            return back()->withErrors(['items' => 'Menu yang dipilih tidak valid.'])->withInput();
        }

        $total = 0;
        foreach ($data['items'] as $item) {
            $total += $menus[$item['menu_id']]->price * $item['qty'];
        }

        $order = DB::transaction(function () use ($data, $menus, $total) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'kode' => $this->nextKode(),
                'nama_pembeli' => $data['nama_pembeli'],
                'no_wa' => Order::normalizeWa($data['no_wa'] ?? null),
                'catatan' => $data['catatan'] ?? null,
                'status' => Order::STATUS_BARU,
                'total' => $total,
            ]);

            foreach ($data['items'] as $item) {
                $menu = $menus[$item['menu_id']];

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $menu->id,
                    'nama_menu' => $menu->name,
                    'harga' => $menu->price,
                    'qty' => $item['qty'],
                    'subtotal' => $menu->price * $item['qty'],
                ]);
            }

            return $order;
        });

        return redirect()
            ->route('seller.pesanan.index')
            ->with('success', 'Pesanan ' . $order->kode . ' berhasil dicatat.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $this->authorizeOrder($order);

        $data = $request->validate([
            'status' => ['required', 'in:' . implode(',', array_keys(Order::statuses()))],
        ]);

        $sebelumnya = $order->status;
        if ($sebelumnya === $data['status']) {
            return back();
        }

        DB::transaction(function () use ($order, $sebelumnya, $data) {
            if ($sebelumnya === Order::STATUS_SELESAI) {
                $this->restoreStok($order);
            }

            $order->update(['status' => $data['status']]);

            if ($data['status'] === Order::STATUS_SELESAI) {
                $this->applyStok($order);
            }
        });

        return back()->with('success', 'Status pesanan ' . $order->kode . ' diubah menjadi ' . $order->fresh()->statusLabel() . '.');
    }

    public function destroy(Order $order)
    {
        $this->authorizeOrder($order);

        if ($order->isSelesai()) {
            $this->restoreStok($order);
        }

        $kode = $order->kode;
        $order->delete();

        return back()->with('success', 'Pesanan ' . $kode . ' berhasil dihapus.');
    }

    protected function applyFilters($query, ?string $status, string $search, ?string $from, ?string $to): void
    {
        if ($status) {
            $query->where('status', $status);
        }

        if ($search !== '') {
            $query->where(function ($inner) use ($search) {
                $inner->where('kode', 'like', '%' . $search . '%')
                    ->orWhere('nama_pembeli', 'like', '%' . $search . '%')
                    ->orWhere('no_wa', 'like', '%' . $search . '%');
            });
        }

        if ($from) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to) {
            $query->whereDate('created_at', '<=', $to);
        }
    }

    protected function applyStok(Order $order): void
    {
        foreach ($order->items()->whereNotNull('menu_id')->get() as $item) {
            $menu = $item->menu;

            if (! $menu) {
                continue;
            }

            $terpakai = min($item->qty, $menu->stock);

            if ($terpakai < 1) {
                continue;
            }

            $menu->decrement('stock', $terpakai);
            $menu->increment('sold', $terpakai);
            $item->update(['qty_terpakai' => $terpakai]);

            if ($menu->fresh()->stock === 0) {
                $menu->update(['available' => false]);
            }
        }
    }

    protected function restoreStok(Order $order): void
    {
        foreach ($order->items()->whereNotNull('menu_id')->where('qty_terpakai', '>', 0)->get() as $item) {
            $menu = $item->menu;

            if (! $menu) {
                $item->update(['qty_terpakai' => 0]);

                continue;
            }

            $menu->increment('stock', $item->qty_terpakai);
            $menu->decrement('sold', $item->qty_terpakai);

            if ($menu->fresh()->stock > 0 && ! $menu->available) {
                $menu->update(['available' => true]);
            }

            $item->update(['qty_terpakai' => 0]);
        }
    }

    protected function nextKode(): string
    {
        $prefix = 'P' . now()->format('Ymd');
        $terakhir = Order::where('kode', 'like', $prefix . '%')
            ->orderByDesc('kode')
            ->value('kode');

        $urutan = $terakhir ? ((int) substr($terakhir, -3)) + 1 : 1;

        do {
            $kode = $prefix . str_pad((string) $urutan, 3, '0', STR_PAD_LEFT);
            $urutan++;
        } while (Order::where('kode', $kode)->exists());

        return $kode;
    }

    protected function filterStatus(Request $request): ?string
    {
        $status = $request->query('status');
        $status = is_string($status) ? $status : '';

        return array_key_exists($status, Order::statuses()) ? $status : null;
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

    protected function authorizeOrder(Order $order): void
    {
        abort_unless($order->user_id === auth()->id(), 403);
    }
}
