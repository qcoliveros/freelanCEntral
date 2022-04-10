<?php

namespace App\Models;

use App\Models\Parameter\SkillProficiency;
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
        return $this->hasOne(SoftSkill::class, 'id', 'skill_id');
    }

    public function proficiency()
    {
        return $this->hasOne(SkillProficiency::class, 'id', 'proficiency_id');
    }
}
