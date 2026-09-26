<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuLike;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->query('sort') === 'terbaru' ? 'terbaru' : 'populer';

        $menus = $this->menuQuery()
            ->when(
                $sort === 'terbaru',
                fn (Builder $query) => $query->orderByDesc('created_at'),
                fn (Builder $query) => $this->orderByMostLiked($query),
            )
            ->take(6)
            ->get();

        // Menu yang paling banyak sukanya -> masuk rekomendasi.
        $topMenus = $this->menuQuery()
            ->has('likes')
            ->orderByDesc('likes_count')
            ->orderByDesc('sold')
            ->orderByDesc('created_at')
            ->take(3)
            ->get();

        $featuredMenu = $topMenus->first() ?? $menus->first();

        $likedIds = MenuLike::likedMenuIds(
            $menus->pluck('id')->merge($topMenus->pluck('id'))->merge([$featuredMenu?->id])
        );

        $recommendedIds = $topMenus->pluck('id')->map(fn ($id) => (int) $id)->all();

        return view('welcome', [
            'menus' => $menus,
            'topMenus' => $topMenus,
            'featuredMenu' => $featuredMenu,
            'topSellers' => $this->topSellers(),
            'likedIds' => $likedIds,
            'recommendedIds' => $recommendedIds,
            'sort' => $sort,
            'totalLikes' => MenuLike::query()->count(),
        ]);
    }

    public function jadwalKuliner(Request $request)
    {
        $category = $request->query('category');
        $day = $request->query('day', 'SEN');
        $sort = $request->query('sort') === 'terbaru' ? 'terbaru' : 'populer';

        $menus = $this->menuQuery()
            ->when($category, fn (Builder $query) => $query->where('category', $category))
            ->when($day, fn (Builder $query) => $query->whereJsonContains('days', $day))
            ->when(
                $sort === 'terbaru',
                fn (Builder $query) => $query->orderByDesc('created_at'),
                fn (Builder $query) => $this->orderByMostLiked($query),
            )
            ->get();

        $likedIds = MenuLike::likedMenuIds($menus->pluck('id'));

        return view('jadwal-kuliner', [
            'active' => 'jadwal-kuliner',
            'menus' => $menus,
            'topSellers' => $this->topSellers(),
            'likedIds' => $likedIds,
            'selectedCategory' => $category,
            'selectedDay' => $day,
            'sort' => $sort,
        ]);
    }

    private function menuQuery(): Builder
    {
        return Menu::with('seller')
            ->withCount('likes')
            ->where('available', true);
    }

    /**
     * Urutan rekomendasi: makin banyak suka, makin di atas.
     */
    private function orderByMostLiked(Builder $query): Builder
    {
        return $query
            ->orderByDesc('likes_count')
            ->orderByDesc('sold')
            ->orderByDesc('created_at');
    }

    /**
     * Lapak favorit = lapak yang sukanya paling banyak, jumlah menu jadi pemutus seri.
     */
    private function topSellers()
    {
        return User::where('role', 'seller')
            ->where('lapak_buka', true)
            ->withCount('menus')
            ->addSelect([
                'likes_total' => MenuLike::query()
                    ->selectRaw('count(*)')
                    ->join('menus', 'menus.id', '=', 'menu_likes.menu_id')
                    ->whereColumn('menus.user_id', 'users.id'),
            ])
            ->orderByDesc('likes_total')
            ->orderByDesc('menus_count')
            ->take(3)
            ->get();
    }
}
