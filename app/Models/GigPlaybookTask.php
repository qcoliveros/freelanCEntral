<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GigPlaybookTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'gig_playbook_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'status',
    ];

    public function comments()
    {
        return $this->hasMany(GigPlaybookTaskComment::class);
    }

    public function scopeOrderByStartDate($query)
    {
        $query->orderBy('start_date');
    }
}
