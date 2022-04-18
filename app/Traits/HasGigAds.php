<?php

namespace App\Traits;

use App\Models\GigAd;

trait HasGigAds
{
    public function gigAds()
    {
        return $this->hasMany(GigAd::class);
    }
}
