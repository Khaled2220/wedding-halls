<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'hall_id',
    'image',
])]


class HallImage extends Model
{
    public function hall():BelongsTo
    {
        return $this->belongsTo(Hall::class);
    }
}
