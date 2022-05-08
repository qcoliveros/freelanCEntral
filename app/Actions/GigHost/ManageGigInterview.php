<?php

namespace App\Actions\GigHost;

use App\Contracts\GigHost\ManagesGigInterview;
use App\Models\GigApplication;
use App\Models\GigInterview;
use Illuminate\Support\Facades\Validator;

class ManageGigInterview implements ManagesGigInterview
{
    public function schedule($user, array $input)
    {
        Validator::make($input, [
            'interview_date' => ['required', 'date', 'after:now'],
        ])->validateWithBag('gigInterviewError');

        if (!isset($input['interview_id'])) {
            $gigApp = GigApplication::find($input['gig_app_id']);
            if ($gigApp !== null) {
                GigInterview::create([
                    'gig_app_id' => $gigApp->id,
                    'interview_date' => $input['interview_date'],
                    'status' => 'Submitted',
                ]);
            }
        } else {
            GigInterview::find($input['interview_id'])->update([
                'interview_date' => $input['interview_date'],
            ]);
        }
    }
}
