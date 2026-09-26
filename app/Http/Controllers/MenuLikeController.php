<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuLike;
use Illuminate\Http\Request;

class MenuLikeController extends Controller
{
    /**
     * Toggle suka untuk satu menu. Bisa dipakai tanpa login (kunci pengunjung
     * disimpan di session), dan tetap jalan kalau JavaScript dimatikan.
     */
    public function toggle(Request $request, Menu $menu)
    {
        $voterKey = MenuLike::currentVoterKey();

        $existing = MenuLike::query()
            ->where('menu_id', $menu->id)
            ->where('voter_key', $voterKey)
            ->first();

        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            MenuLike::query()->create([
                'menu_id' => $menu->id,
                'voter_key' => $voterKey,
            ]);
            $liked = true;
        }

        $count = MenuLike::query()->where('menu_id', $menu->id)->count();

        if ($request->expectsJson()) {
            return response()->json([
                'liked' => $liked,
                'count' => $count,
            ]);
        }

        return back();
    }
}
