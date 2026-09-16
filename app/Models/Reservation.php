<?php

namespace App\Models;

use App\Models\Foods\Food;
use App\Models\Foods\Sweet;
use App\Models\Payment\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reservation extends Model
{
    protected $fillable = [
        'customer_id',
        'hall_id',
        'reservation_date',
        'start_time',
        'end_time',
        'guests',
        'total_price',
        'deposit_amount',
        'status',
    ];

    protected $casts = [
        'reservation_date' => 'date',
        'total_price' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'customer_id'
        );
    }

    public function hall(): BelongsTo
    {
        return $this->belongsTo(
            Hall::class,'hall_id'
        );
    }

    public function payment(): HasOne
    {
        return $this->hasOne(
            Payment::class,'reservation_id'
        );
    }

    public function foods(): BelongsToMany
    {
        return $this->belongsToMany(
            Food::class,
            'reservation_food',
            'reservation_id',
            'food_id'
        )
        ->withPivot('price')
        ->withTimestamps();
    }

    public function sweets(): BelongsToMany
    {
        return $this->belongsToMany(
            Sweet::class,
            'reservation_sweet',
            'reservation_id',
            'sweet_id'
        )
        ->withPivot('price')
        ->withTimestamps();
    }
}