<?php

namespace App\Actions\Profile;

use App\Contracts\Profile\ManagesUserSoftSkill;
use App\Models\UserSoftSkill;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ManageUserSoftSkill implements ManagesUserSoftSkill
{
    public function store($user, array $input)
    {
        $this->validate($user->id, $input);

        $user->userSoftSkills()->create($input);
    }

    public function update($user, array $input)
    {
        if (isset($input['id'])) {
            $this->validate($user->id, $input);

            UserSoftSkill::find($input['id'])->update($input);
        }
    }

    public function delete(array $input)
    {
        if (isset($input['id'])) {
            UserSoftSkill::find($input['id'])->delete();
        }
    }

    private function validate($userId, array $input)
    {
        $customAttributes = array(
            'skill_id' => 'skill',
            'proficiency_id' => 'proficiency level',
        );

        Validator::make($input, [
            'skill_id' => ['required', Rule::unique('user_soft_skills', 'skill_id')->where(
                function ($query) use ($userId) {
                    return $query->where('user_id', $userId);
                })->ignore($input['id'])],
            'proficiency_id' => ['required'],
            'description' => ['nullable', 'string', 'max:2048'],
        ], [], $customAttributes)->validateWithBag('softSkillError');
    }
}
