<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        $customAttributes = array(
            'phone_type_id' => 'phone type',
            'messenger_type_id' => 'messenger type',
            'industry_id', 'industry',
        );

        Validator::make($input, [
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required_with:phone_type_id', 'max:12', isset($input['phone']) ? Rule::unique('users')->ignore($user->id) : ''],
            'phone_type_id' => ['required_with:phone'],
            'messenger' => ['required_with:messenger_type_id', 'max:100', isset($input['messenger']) ? Rule::unique('users')->ignore($user->id) : ''],
            'messenger_type_id' => ['required_with:messenger'],
            'website_url' => ['nullable', 'string', 'max:2048'],
            'industry_id' => ['nullable'],
            ], [], $customAttributes)->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'phone' => $input['phone'],
                'phone_type_id' => $input['phone_type_id'],
                'messenger' => $input['messenger'],
                'messenger_type_id' => $input['messenger_type_id'],
                'website_url' => $input['website_url'],
                'industry_id' => $input['industry_id'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
