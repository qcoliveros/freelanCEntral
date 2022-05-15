<?php

namespace App\Contracts\GigHost;

interface ManagesGigApplicant
{
    public function shortlist($user, array $input);

    public function reject($user, array $input);

    public function rejectWithComment($user, array $input);

    public function acceptWithComment($user, array $input);
}
