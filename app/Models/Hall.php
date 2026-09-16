<?php

namespace App\Models;

use App\Models\Foods\Food;
use App\Models\Foods\Sweet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\JobPost;

class Hall extends Model
{
    use HasFactory;

    protected $fillable = [
        'hall_manager_id',
        'name',
        'description',
        'food',
        'sweets',
        'address',
        'phone',
        'price',
        'capacity',
        'status',
        'latitude',
        'longitude',
    ];

    /**
     * Hall manager
     */
    public function hallManager()
    {
        return $this->belongsTo(
            User::class,
            'hall_manager_id'
        );
    }

    /**
     * Hall images
     */
    public function images()
    {
        return $this->hasMany(
            HallImage::class,
            'hall_id'
        );
    }

    /**
     * Foods belonging to this hall
     */
    public function foods()
    {
        return $this->hasMany(
            Food::class,
            'hall_id'
        );
    }

    /**
     * Sweets belonging to this hall
     *
     * We use sweetItems instead of sweets
     * because halls table already has a "sweets" column.
     */
    public function sweetItems()
    {
        return $this->hasMany(
            Sweet::class,
            'hall_id'
        );
    }

    public function jobPosts()
    {
        return $this->hasMany(JobPost::class);
    }
}