<?php

namespace App\Traits;

use App\Models\UserEducation;

trait HasEducations
{
    public function userEducations()
    {
        return $this->hasMany(UserEducation::class);
    }
}
