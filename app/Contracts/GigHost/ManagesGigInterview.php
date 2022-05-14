<?php

namespace App\Contracts\GigHost;

interface ManagesGigInterview
{
    public function createSchedule($user, array $input);

    public function deleteSchedule(array $input);

    public function sendInvite($user, array $input);
}
