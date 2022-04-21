<?php

namespace App\Models;

use App\Models\Parameter\Duration;
use App\Models\Parameter\JobFunction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GigAd extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_title',
        'description',
        'job_function_id',
        'other_job_function',
        'commitment_time',
        'commitment_duration_id',
        'job_start_date',
        'job_end_date',
        'posted_date',
        'is_draft',
        'publish_date',
        'close_date',
    ];

    protected $casts = [
        'is_draft' => 'boolean',
    ];

    public function gigHost()
    {
        return $this->belongsTo(User::class);
    }

    public function jobFunction()
    {
        return $this->hasOne(JobFunction::class, 'id', 'job_function_id');
    }

    public function commitmentDuration()
    {
        return $this->hasOne(Duration::class, 'id', 'commitment_duration_id');
    }

    public function scopeFilter($query, $filter)
    {
        $query->when($filter ?? null, function ($query, $search) {
            $query->where('job_title', 'like', '%'.$search.'%');
        });
    }
}
