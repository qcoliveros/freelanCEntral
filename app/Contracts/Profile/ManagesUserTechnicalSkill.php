<?php

namespace App\Contracts\Profile;

interface ManagesUserTechnicalSkill
{
    public function store($user, array $input);

    public function update($user, array $input);

    public function delete(array $input);
}
