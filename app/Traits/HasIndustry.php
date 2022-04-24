<?php

namespace App\Traits;

use App\Models\Parameter\Industry;

trait HasIndustry
{
    public function industry()
    {
        return $this->hasOne(Industry::class, 'id', 'industry_id');
    }
}
