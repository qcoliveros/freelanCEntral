<?php

namespace App\Actions\Profile;

use App\Contracts\Profile\UpdatesUserAboutInformation;
use Illuminate\Support\Facades\Validator;

class UpdateUserAboutInformation implements UpdatesUserAboutInformation
{
    public function update($user, array $input)
    {
        Validator::make($input, [
            'about' => ['required', 'string', 'max:4096'],
        ])->validateWithBag('updateAboutInformation');

        $user->forceFill([
            'about' => $input['about'],
        ])->save();
    }
}
