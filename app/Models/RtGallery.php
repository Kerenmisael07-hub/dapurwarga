<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RtGallery extends Model
{
    protected $table = 'rt_gallery';

    protected $fillable = ['image'];

    public function getImageAttribute(?string $value): ?string
    {
        if (! $value) {
            return null;
        }

        return str_starts_with($value, 'http://') || str_starts_with($value, 'https://')
            ? $value
            : asset($value);
    }
}