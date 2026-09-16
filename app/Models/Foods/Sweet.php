<?php
namespace App\Models\Foods;

use App\Models\Hall;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sweet extends Model
{
    protected $table = 'sweets';

    protected $fillable = [
        'hall_id',
        'price',
    ];

    protected $casts = ['price' => 'decimal:2',];

    public function hall(): BelongsTo
    {
        return $this->belongsTo(Hall::class, 'hall_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(SweetImage::class, 'sweet_id');
    }
}