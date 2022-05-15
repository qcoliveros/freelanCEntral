<?php

namespace App\Contracts\GigHost;

interface ManagesGigPlaybook
{
    public function saveContract(array $input);

    public function sendContract(array $input);

    public function rejectContract(array $input);

    public function acceptContract(array $input);
}
