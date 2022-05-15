<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GigPlaybookContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'gig_playbook_id',
        'clause',
        'signed_date',
        'status',
    ];
}
