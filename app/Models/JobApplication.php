<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'job_post_id', 
        'worker_id', 
        'message', 
        'status', 
        'applied_at', 
        ];

    protected $casts = [ 'applied_at' => 'datetime', ];    

    /** 
      * Job advertisement. 
      */
    public function jobPost(): BelongsTo 
    { 
        return $this->belongsTo(JobPost::class); 
    }

    /** 
      * Worker who applied. 
      */ 
    public function worker(): BelongsTo 
    { 
        return $this->belongsTo(User::class, 'worker_id'); 
    }
}
