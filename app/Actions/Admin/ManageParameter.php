<?php

namespace App\Actions\Admin;

use App\Contracts\Admin\ManagesParameter;
use App\Models\Parameter\Industry;
use App\Models\Parameter\JobFunction;
use App\Models\Parameter\MessengerType;
use App\Models\Parameter\PhoneType;
use App\Models\Parameter\SoftSkill;
use App\Models\Parameter\TechnicalSkill;
use Illuminate\Support\Facades\Validator;

class ManageParameter implements ManagesParameter
{
    public function saveIndustry($user, array $input)
    {
        $this->validate($input);

        if (isset($input['id'])) {
            Industry::find($input['id'])->update($input);
        } else {
            Industry::create($input);
        }
    }

    public function saveJobFunction($user, array $input)
    {
        $this->validate($input);

        if (isset($input['id'])) {
            JobFunction::find($input['id'])->update($input);
        } else {
            JobFunction::create($input);
        }
    }

    public function saveMessengerType($user, array $input)
    {
        $this->validate($input);

        if (isset($input['id'])) {
            MessengerType::find($input['id'])->update($input);
        } else {
            MessengerType::create($input);
        }
    }

    public function savePhoneType($user, array $input)
    {
        $this->validate($input);

        if (isset($input['id'])) {
            PhoneType::find($input['id'])->update($input);
        } else {
            PhoneType::create($input);
        }
    }

    public function saveSoftSkill($user, array $input)
    {
        $this->validate($input);

        if (isset($input['id'])) {
            SoftSkill::find($input['id'])->update($input);
        } else {
            SoftSkill::create($input);
        }
    }

    public function saveTechnicalSkill($user, array $input)
    {
        $this->validate($input);

        if (isset($input['id'])) {
            TechnicalSkill::find($input['id'])->update($input);
        } else {
            TechnicalSkill::create($input);
        }
    }

    private function validate(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'description' => [$input['has_description'] ? 'required' : 'nullable', 'string', 'max:2048'],
        ])->validateWithBag('parameterError');
    }
}
