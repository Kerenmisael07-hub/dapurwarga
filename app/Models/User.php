<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'kategori_layanan',
        'nama_lapak',
        'no_wa',
        'lapak_buka',
        'foto_profile',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'lapak_buka' => 'boolean',
        ];
    }

    public function menus()
    {
        return $this->hasMany(Menu::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    /**
     * Foto profil selalu disimpan di public/uploads, jadi path relatifnya
     * diubah jadi URL. Kalau kosong, null (dipakai fallback inisial).
     */
    public function getFotoProfileAttribute(?string $value): ?string
    {
        if (! $value) {
            return null;
        }

        return str_starts_with($value, 'http://') || str_starts_with($value, 'https://')
            ? $value
            : asset($value);
    }

    public function getInitialsAttribute(): string
    {
        $name = trim($this->name);
        $parts = preg_split('/\s+/', $name) ?: [];

        return count($parts) >= 2
            ? mb_strtoupper(mb_substr($parts[0], 0, 1).mb_substr($parts[1], 0, 1))
            : mb_strtoupper(mb_substr($name, 0, 2));
    }
}
