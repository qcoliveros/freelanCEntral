<?php

namespace App\Traits;

use App\Models\UserLanguage;

trait HasLanguages
{
    public function userLanguages()
    {
        return $this->hasMany(UserLanguage::class);
    }
}
