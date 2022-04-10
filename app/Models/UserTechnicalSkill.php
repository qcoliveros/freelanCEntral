<?php

namespace App\Models;

use App\Models\Parameter\TechnicalSkill;
use App\Models\Parameter\SkillProficiency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTechnicalSkill extends Model
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
        return $this->hasOne(TechnicalSkill::class, 'id', 'skill_id');
    }

    public function proficiency()
    {
        return $this->hasOne(SkillProficiency::class, 'id', 'proficiency_id');
    }
}
