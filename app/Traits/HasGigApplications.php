<?php

namespace App\Traits;

use App\Models\GigApplication;

trait HasGigApplications
{
    public function gigApplications()
    {
        return $this->hasMany(GigApplication::class);
    }
}
