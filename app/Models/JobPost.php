<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Relations\BelongsTo; 
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobPost extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'hall_manager_id', 
        'hall_id', 
        'title', 
        'description', 
        'requirements', 
        'salary', 
        'employment_type', 
        'workers_needed', 
        'deadline', 
        'status', 
    ];

    protected $casts = [ 
        'salary' => 'decimal:2', 
        'workers_needed' => 'integer', 
        'deadline' => 'date', 
    ];

    /** 
     * Hall Manager who created the advertisement. 
     */ 
    public function hallManager(): BelongsTo 
    { 
        return $this->belongsTo(User::class, 'hall_manager_id'); 
    }

    /** 
     *Hall related to this job advertisement. 
     */
    public function hall(): BelongsTo 
    { 
        return $this->belongsTo(Hall::class); 
    }

    /** 
      * Applications for this job. 
      */ 
    public function applications(): HasMany 
    { 
        return $this->hasMany(JobApplication::class); 
    }
}
