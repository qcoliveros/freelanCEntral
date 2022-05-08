<?php

namespace App\Actions\GigHost;

use App\Contracts\GigHost\ManagesGigInterview;
use App\Models\GigApplication;
use App\Models\GigInterview;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ManageGigInterview implements ManagesGigInterview
{
    public function schedule($user, array $input)
    {
        $gigAppId = $input['gig_app_id'];
        Validator::make($input, [
            'interview_date' => ['required', 'date', 'after:now',
                Rule::unique('gig_interviews', 'interview_date')->where(
                    function ($query) use ($gigAppId) {
                        return $query->where('gig_app_id', $gigAppId);
                    })
                ],
        ])->validateWithBag('gigInterviewError');

        if (!isset($input['interview_id'])) {
            $gigApp = GigApplication::find($input['gig_app_id']);
            if ($gigApp !== null) {
                GigInterview::create([
                    'gig_app_id' => $gigApp->id,
                    'interview_date' => strtotime($input['interview_date']),
                    'status' => 'Draft',
                ]);
            }
        } else {
            GigInterview::find($input['interview_id'])->update([
                'interview_date' => $input['interview_date'],
            ]);
        }
    }

    public function delete(array $input)
    {
        if (isset($input['interview_id'])) {
            GigInterview::find($input['interview_id'])->delete();
        }
    }

    public function submit($user, array $input)
    {
        $gigInterviewList = GigInterview::where('gig_app_id', $input['gig_app_id'])->where('status', 'Draft')->get();
        if ($gigInterviewList != null && count($gigInterviewList) > 0) {
            foreach ($gigInterviewList as $gigInterview) {
                $gigInterview->update(['status' => 'Submitted']);
            }
        }
    }
}
