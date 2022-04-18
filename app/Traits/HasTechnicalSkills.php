<?php

namespace App\Traits;

use App\Models\UserTechnicalSkill;

trait HasTechnicalSkills
{
    public function userTechnicalSkills()
    {
        return $this->hasMany(UserTechnicalSkill::class);
    }
}
