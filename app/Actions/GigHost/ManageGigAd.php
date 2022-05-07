<?php

namespace App\Actions\GigHost;

use App\Contracts\GigHost\ManagesGigAd;
use App\Models\GigAd;
use App\Models\Parameter\Duration;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;

class ManageGigAd implements ManagesGigAd
{
    public function save($user, array $input)
    {
        $this->validate($input);

        $input['commitment_duration_id'] = Duration::where('name', 'Hour(s)')->value('id');
        $input['status'] = 'Draft';

        $this->createOrUpdate($user, $input);
    }

    public function publish($user, array $input)
    {
        $this->validate($input);

        $input['commitment_duration_id'] = Duration::where('name', 'Hour(s)')->value('id');
        $input['publish_date'] = Date::now();
        $input['status'] = 'Published';

        $this->createOrUpdate($user, $input);
    }

    public function close($user, array $input)
    {
        $this->validate($input);

        $input['close_date'] = Date::now();
        $input['status'] = 'Closed';

        $this->createOrUpdate($user, $input);
    }

    public function delete(array $input)
    {
        if (isset($input['id'])) {
            GigAd::find($input['id'])->delete();
        }
    }

    private function validate(array $input)
    {
        $customAttributes = array(
            'job_function_id' => 'job function',
        );

        Validator::make($input, [
            'job_title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:4096'],
            'job_function_id' => ['required'],
            'other_job_function' => ['nullable', 'string', 'max:255'],
            'commitment_time' => ['required', 'integer', 'between:5,40'],
            'job_start_date' => ['required', 'date', 'after:now'],
            'job_end_date' => ['required', 'date', 'after:job_start_date'],
            ], [], $customAttributes)->validateWithBag('gigError');
    }

    private function createOrUpdate($user, array $input)
    {
        if (!isset($input['id'])) {
            $user->gigAds()->create($input);
        } else {
            GigAd::find($input['id'])->update($input);
        }
    }
}
