<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GigInterview extends Model
{
    use HasFactory;

    protected $fillable = [
        'gig_app_id',
        'interview_date',
        'comment',
        'status',
    ];

    protected $casts = [
        'interview_date' => 'datetime',
    ];

    public function gigApplication()
    {
        return $this->belongsTo(GigApplication::class, 'gig_app_id', 'id');
    }
}
