<?php

namespace App\Actions\Profile;

use App\Contracts\Profile\ManagesUserEducation;
use App\Models\UserEducation;
use Illuminate\Support\Facades\Validator;

class ManageUserEducation implements ManagesUserEducation
{
    public function store($user, array $input)
    {
        $this->validate($input);

        $user->userEducations()->create($input);
    }

    public function update(array $input)
    {
        if (isset($input['id'])) {
            $this->validate($input);

            UserEducation::find($input['id'])->update($input);
        }
    }

    public function delete(array $input)
    {
        if (isset($input['id'])) {
            UserEducation::find($input['id'])->delete();
        }
    }

    private function validate(array $input)
    {
        $customAttributes = array(
            'field' => 'field of study',
        );

        Validator::make($input, [
            'school' => ['required', 'string', 'max:255'],
            'degree' => ['nullable', 'string', 'max:255'],
            'field' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'date', 'before:now'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
            'grade' => ['nullable'],
            'description' => ['nullable', 'string', 'max:2048'],
            ], [], $customAttributes)->validateWithBag('educationError');
    }
}
