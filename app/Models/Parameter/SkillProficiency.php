<?php

namespace App\Models\Parameter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillProficiency extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}
