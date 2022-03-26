<?php

namespace App\Contracts\Profile;

interface UpdatesUserAboutInformation
{
    public function update($user, array $input);
}
