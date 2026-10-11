<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RtAnnouncement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'category',
        'tanggal',
        'is_urgent',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'is_urgent' => 'boolean',
    ];
}