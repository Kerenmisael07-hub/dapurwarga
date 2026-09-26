<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'menu_id',
        'nama_menu',
        'harga',
        'qty',
        'subtotal',
        'qty_terpakai',
    ];

    protected $casts = [
        'harga' => 'integer',
        'qty' => 'integer',
        'subtotal' => 'integer',
        'qty_terpakai' => 'integer',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
