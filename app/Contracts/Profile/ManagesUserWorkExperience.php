<?php

namespace App\Contracts\Profile;

interface ManagesUserWorkExperience
{
    public function store($user, array $input);

    public function update(array $input);

    public function delete(array $input);
}
