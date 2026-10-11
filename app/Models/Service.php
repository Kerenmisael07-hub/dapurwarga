<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'category',
        'price',
        'price_unit',
        'description',
        'foto',
        'status',
        'whatsapp_number',
    ];

    protected $casts = [
        'price' => 'integer',
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(ServiceOrder::class, 'service_id');
    }

    public function getIsAvailableAttribute(): bool
    {
        return $this->status === 'tersedia';
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp '.number_format((int) $this->price, 0, ',', '.');
    }

    /**
     * Pakai nomor WhatsApp khusus layanan kalau ada, kalau tidak
     * jatuh ke nomor WhatsApp penyedia jasa.
     */
    public function whatsappNumber(): string
    {
        $raw = $this->whatsapp_number ?: $this->seller?->no_wa;
        $number = preg_replace('/[^0-9]/', '', (string) $raw);

        if (str_starts_with($number, '0')) {
            return '62'.substr($number, 1);
        }

        if (str_starts_with($number, '8')) {
            return '62'.$number;
        }

        return $number;
    }

    public function whatsappUrl(string $message): string
    {
        $number = $this->whatsappNumber();

        return $number ? 'https://wa.me/'.$number.'?text='.rawurlencode($message) : '#';
    }
}
