<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Rules\GambarUpload;
use App\Support\HandlesSquareImages;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    use HandlesSquareImages;

    public function create()
    {
        return view('seller.form', ['menu' => null]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $image = $this->storeImage($request);
        if ($image) {
            $data['image_url'] = $image;
        }
        unset($data['image']);
        $data['user_id'] = auth()->id();

        Menu::create($data);

        return redirect()->route('seller.dashboard')->with('success', 'Menu kuliner berhasil ditambahkan.');
    }

    public function edit(Menu $menu)
    {
        $this->authorizeMenu($menu);

        return view('seller.form', ['menu' => $menu]);
    }

    public function update(Request $request, Menu $menu)
    {
        $this->authorizeMenu($menu);

        $data = $this->validated($request);
        $image = $this->storeImage($request);
        if ($image) {
            $this->deleteImage($menu->getRawOriginal('image_url'));
            $data['image_url'] = $image;
        }
        unset($data['image']);
        $menu->update($data);

        return redirect()->route('seller.dashboard')->with('success', 'Menu kuliner berhasil diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        $this->authorizeMenu($menu);
        $this->deleteImage($menu->getRawOriginal('image_url'));
        $menu->delete();

        return back()->with('success', 'Menu kuliner berhasil dihapus.');
    }

    public function toggle(Menu $menu)
    {
        $this->authorizeMenu($menu);
        $menu->update(['available' => ! $menu->available]);

        return back()->with('success', $menu->available ? 'Menu tersedia kembali.' : 'Menu ditandai habis.');
    }

    public function adjustStock(Request $request, Menu $menu)
    {
        $this->authorizeMenu($menu);

        $request->validate([
            'direction' => ['required', 'in:tambah,kurang'],
        ]);

        if ($request->direction === 'kurang') {
            if ($menu->stock > 0) {
                $menu->decrement('stock');
                $menu->increment('sold');
                if ($menu->fresh()->stock === 0) {
                    $menu->update(['available' => false]);
                }
            }
        } else {
            $menu->increment('stock');
            if ($menu->sold > 0) {
                $menu->decrement('sold');
            }
        }

        return back()->with('success', $menu->fresh()->stock === 0 ? 'Stok habis, menu otomatis ditandai Habis.' : 'Stok menu diperbarui.');
    }

    protected function authorizeMenu(Menu $menu): void
    {
        abort_unless($menu->user_id === auth()->id(), 403);
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['required', 'integer', 'min:0'],
            'category' => ['required', 'string', 'max:50'],
            'image' => ['nullable', new GambarUpload],
            'stock' => ['required', 'integer', 'min:0'],
            'days' => ['nullable', 'array'],
            'days.*' => ['string'],
            'available' => ['nullable', 'boolean'],
        ]);
    }

    protected function storeImage(Request $request): ?string
    {
        if (! $request->hasFile('image')) {
            return null;
        }

        return $this->storeSquareImage($request->file('image'), 'uploads/menus');
    }

    protected function deleteImage(?string $path): void
    {
        $this->deleteStoredImage($path);
    }
}
