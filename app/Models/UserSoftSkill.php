<?php

namespace App\Models;

use App\Models\Parameter\Proficiency;
use App\Models\Parameter\SoftSkill;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSoftSkill extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'skill_id',
        'proficiency_id',
        'description',
    ];

    public function skill()
    {
        $this->hasOne(SoftSkill::class, 'id', 'skill_id');
    }

    public function proficiency()
    {
        return $this->hasOne(Proficiency::class, 'id', 'proficiency_id');
    }
}
