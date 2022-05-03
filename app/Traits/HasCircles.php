<?php

namespace App\Traits;

use App\Models\UserCircle;

trait HasCircles
{
    public function circles()
    {
        return $this->hasMany(UserCircle::class);
    }
}
