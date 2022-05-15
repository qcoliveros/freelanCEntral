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
}
