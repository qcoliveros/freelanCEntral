<?php

namespace App\Actions\GigHost;

use App\Contracts\GigHost\ManagesGig;
use App\Models\Gig;
use App\Models\Parameter\Duration;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;

class ManageGig implements ManagesGig
{
    public function store($user, array $input)
    {
        $this->validate($input);
        $input['commitment_duration'] = Duration::where('name', 'Hour(s)')->value('id');
        if (!$input['is_draft']) {
            $input['posted_date'] = Date::now();
        }

        $user->gigAds()->create($input);
    }

    public function update(array $input)
    {
        if (isset($input['id'])) {
            $this->validate($input);
            if (!$input['is_draft']) {
                $input['posted_date'] = Date::now();
            }

            Gig::find($input['id'])->update($input);
        }
    }

    public function delete(array $input)
    {
        if (isset($input['id'])) {
            Gig::find($input['id'])->delete();
        }
    }

    private function validate(array $input)
    {
        Validator::make($input, [
            'job_title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2048'],
            'job_function' => ['required'],
            'other_job_function' => ['nullable', 'string', 'max:255'],
            'commitment_time' => ['required', 'integer', 'between:5,40'],
            'job_start_date' => ['required', 'date', 'after:now'],
            'job_end_date' => ['required', 'date', 'after:job_start_date'],
        ])->validateWithBag('gigError');
    }
}
