<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEducation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'school',
        'degree',
        'field',
        'start_date',
        'end_date',
        'grade',
        'description',
    ];
}
