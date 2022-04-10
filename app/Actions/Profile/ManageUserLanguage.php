<?php

namespace App\Actions\Profile;

use App\Contracts\Profile\ManagesUserLanguage;
use App\Models\UserLanguage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ManageUserLanguage implements ManagesUserLanguage
{
    public function store($user, array $input)
    {
        $this->validate($user->id, $input);

        $user->userLanguages()->create($input);
    }

    public function update($user, array $input)
    {
        if (isset($input['id'])) {
            $this->validate($user->id, $input);

            UserLanguage::find($input['id'])->update($input);
        }
    }

    public function delete(array $input)
    {
        if (isset($input['id'])) {
            UserLanguage::find($input['id'])->delete();
        }
    }

    private function validate($userId, array $input)
    {
        $customAttributes = array(
            'language_id' => 'language',
            'speaking_proficiency_id' => 'speaking proficiency level',
            'writing_proficiency_id' => 'writing proficiency level',
            'reading_proficiency_id' => 'reading proficiency level',
        );

        Validator::make($input, [
            'language_id' => ['required', Rule::unique('user_languages', 'language_id')->where(
                function ($query) use ($userId) {
                    return $query->where('user_id', $userId);
                })->ignore($input['id'])],
            'speaking_proficiency_id' => ['required'],
            'writing_proficiency_id' => ['required'],
            'reading_proficiency_id' => ['required'],
        ], [], $customAttributes)->validateWithBag('languageError');
    }
}
