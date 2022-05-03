<?php

namespace App\Contracts\Gigger;

interface ManagesGigApplication
{
    public function apply($user, array $input);

    public function withdraw($user, array $input);
}
