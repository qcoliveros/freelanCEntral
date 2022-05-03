<?php

namespace App\Contracts\Other;

interface ManagesUserCircle
{
    public function followUser($user, array $input);

    public function unfollowUser($user, array $input);
}
