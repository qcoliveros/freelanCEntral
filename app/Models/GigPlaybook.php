<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GigPlaybook extends Model
{
    use HasFactory;

    protected $fillable = [
        'gig_host_id',
        'gigger_id',
        'job_title',
        'job_start_date',
        'job_end_date',
        'status',
    ];

    public function gigHost()
    {
        return $this->belongsTo(User::class, 'gig_host_id', 'id');
    }

    public function gigger()
    {
        return $this->belongsTo(User::class, 'gigger_id', 'id');
    }

    public function contract()
    {
        return $this->hasOne(GigPlaybookContract::class, 'gig_playbook_id', 'id');
    }

    public function tasks()
    {
        return $this->hasMany(GigPlaybookTask::class);
    }

    public function scopeFilterByJobTitle($query, $filter)
    {
        $query->when($filter ?? null, function ($query, $search) {
            $query->where('job_title', 'LIKE', '%'.$search.'%');
        });
    }
}
