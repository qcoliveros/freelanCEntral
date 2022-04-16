<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gig extends Model
{
    use HasFactory;

    protected $fillable = [
        'gig_host_id',
        'job_title',
        'description',
        'job_function',
        'other_job_function',
        'commitment_time',
        'commitment_duration',
        'job_start_date',
        'job_end_date',
        'posted_date',
        'is_draft',
        'is_post_end'
    ];

    protected $casts = [
        'is_draft' => 'boolean',
        'is_post_end' => 'boolean',
    ];

    public function gigHost()
    {
        return $this->belongsTo(User::class);
    }

    public function candidates()
    {
        return $this->hasMany(User::class);
    }

    public function giggers()
    {
        return $this->hasMany(User::class);
    }
}
