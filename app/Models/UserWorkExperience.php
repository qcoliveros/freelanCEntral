<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWorkExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'employment_type',
        'company_name',
        'location',
        'start_date',
        'end_date',
        'is_current',
        'industry',
    ];
}
