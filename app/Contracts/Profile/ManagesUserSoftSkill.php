<?php

namespace App\Contracts\Profile;

interface ManagesUserSoftSkill
{
    public function store($user, array $input);

    public function update($user, array $input);

    public function delete(array $input);
}