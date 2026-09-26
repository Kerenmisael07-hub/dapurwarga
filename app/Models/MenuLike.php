<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MenuLike extends Model
{
    protected $fillable = [
        'menu_id',
        'voter_key',
    ];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * Kunci unik pengunjung: pengguna yang sudah login memakai id-nya,
     * pengunjung umum (tanpa login) memakai token acak dari session.
     */
    public static function currentVoterKey(): string
    {
        if (Auth::check()) {
            return 'u:'.Auth::id();
        }

        if (! session()->has('guest_voter_key')) {
            session()->put('guest_voter_key', Str::random(40));
        }

        return 'g:'.session('guest_voter_key');
    }

    /**
     * Id menu yang sudahlikes oleh pengunjung saat ini.
     *
     * @param  Collection<int, int>|array<int, int>  $menuIds
     * @return array<int, int>
     */
    public static function likedMenuIds($menuIds): array
    {
        $menuIds = collect($menuIds)->filter()->unique()->values();

        if ($menuIds->isEmpty()) {
            return [];
        }

        return static::query()
            ->where('voter_key', static::currentVoterKey())
            ->whereIn('menu_id', $menuIds)
            ->pluck('menu_id')
            ->map(fn ($id) => (int) $id)
            ->all();
    }
}
