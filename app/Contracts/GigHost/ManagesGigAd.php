<?php

namespace App\Contracts\GigHost;

interface ManagesGigAd
{
    public function save($user, array $input);

    public function publish($user, array $input);

    public function close($user, array $input);

    public function delete(array $input);
}
