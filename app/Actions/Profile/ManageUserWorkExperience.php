<?php

namespace App\Actions\Profile;

use App\Contracts\Profile\ManagesUserWorkExperience;
use App\Models\UserWorkExperience;
use Illuminate\Support\Facades\Validator;

class ManageUserWorkExperience implements ManagesUserWorkExperience
{
    public function store($user, array $input)
    {
        $this->validate($input);

        $user->userWorkExperiences()->create($input);
    }

    public function update(array $input)
    {
        if (isset($input['id'])) {
            $this->validate($input);

            UserWorkExperience::find($input['id'])->update($input);
        }
    }

    public function delete(array $input)
    {
        if (isset($input['id'])) {
            UserWorkExperience::find($input['id'])->delete();
        }
    }

    private function validate(array $input)
    {
        Validator::make($input, [
            'title' => ['required', 'string', 'max:255'],
            'employment_type' => ['required'],
            'company_name' => ['required', 'string', 'max:255'],
            'location' => ['required'],
            'start_date' => ['required', 'date', 'before:now'],
            'end_date' => ['required_without:is_present', 'date'],
            'industry' => ['required'],
            'description' => ['required', 'string', 'max:2048'],
        ])->validateWithBag('workExpereienceError');
    }
}
