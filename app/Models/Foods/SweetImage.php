<?php

namespace App\Models\Foods;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SweetImage extends Model
{
    protected $fillable = [
        'sweet_id',
        'image_path',
    ];

    public function sweet(): BelongsTo
    {
        return $this->belongsTo(Sweet::class);
    }
}