<?php

namespace App\Contracts\Gigger;

interface ManagesGigApplication
{
    public function apply($user, array $input);
}
