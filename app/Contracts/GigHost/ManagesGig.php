<?php

namespace App\Contracts\GigHost;

interface ManagesGig
{
    public function store($user, array $input);

    public function update(array $input);

    public function delete(array $input);
}
