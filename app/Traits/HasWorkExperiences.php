<?php

namespace App\Traits;

use App\Models\UserWorkExperience;

trait HasWorkExperiences
{
    public function userWorkExperiences()
    {
        return $this->hasMany(UserWorkExperience::class);
    }
}
