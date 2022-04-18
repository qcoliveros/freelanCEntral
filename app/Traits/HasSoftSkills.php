<?php

namespace App\Traits;

use App\Models\UserSoftSkill;

trait HasSoftSkills
{
    public function userSoftSkills()
    {
        return $this->hasMany(UserSoftSkill::class);
    }
}
