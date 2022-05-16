<?php

namespace App\Contracts\Admin;

interface ManagesParameter
{
    public function saveIndustry($user, array $input);

    public function saveJobFunction($user, array $input);

    public function saveMessengerType($user, array $input);

    public function savePhoneType($user, array $input);

    public function saveSoftSkill($user, array $input);

    public function saveTechnicalSkill($user, array $input);
}
