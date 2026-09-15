<?php

namespace App\Models\Foods;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FoodImage extends Model
{
    protected $fillable = [
        'food_id',
        'image_path',
    ];

    /**
     * Image belongs to a food.
     */
    public function food(): BelongsTo
    {
        return $this->belongsTo(Food::class);
    }
}