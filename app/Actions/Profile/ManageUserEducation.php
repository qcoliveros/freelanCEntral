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
        Validator::make($input, [
            'school' => ['required', 'string', 'max:255'],
            'degree' => ['required', 'string', 'max:255'],
            'field' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date', 'before:now'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
            'grade' => ['required'],
            'description' => ['required', 'string', 'max:2048'],
        ])->validateWithBag('educationError');
    }
}
