<?php

namespace App\Contracts\GigHost;

interface ManagesGigInterview
{
    public function schedule($user, array $input);
}
