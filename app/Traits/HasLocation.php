<?php

namespace App\Traits;

use App\Models\Parameter\Country;

trait HasLocation
{
    public function location()
    {
        return $this->hasOne(Country::class, 'id', 'location_id');
    }
}
