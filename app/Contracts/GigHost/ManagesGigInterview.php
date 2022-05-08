<?php

namespace App\Contracts\GigHost;

interface ManagesGigInterview
{
    public function schedule($user, array $input);

    public function submit($user, array $input);
}
