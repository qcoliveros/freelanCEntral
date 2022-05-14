<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GigInterviewSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'gig_interview_id',
        'created_by',
        'interview_start',
        'interview_end',
        'status',
    ];

    protected $casts = [
        'interview_date' => 'datetime',
    ];

    public function gigInterview()
    {
        return $this->belongsTo(GigInterview::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }
}
