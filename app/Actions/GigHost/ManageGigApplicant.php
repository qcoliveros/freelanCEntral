<?php

namespace App\Actions\GigHost;

use App\Contracts\GigHost\ManagesGigApplicant;
use App\Models\GigApplication;
use App\Models\GigApplicationTrail;
use App\Models\GigInterview;
use App\Models\GigPlaybook;
use App\Models\GigPlaybookContract;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ManageGigApplicant implements ManagesGigApplicant
{
    public function shortlist($user, array $input)
    {
        $gigApp = GigApplication::find($input['gig_app_id']);
        if ($gigApp !== null) {
            $gigApp->update(['status' => 'Shortlisted']);
            $this->createTrail($user, $gigApp);

            GigInterview::create([
                'gig_app_id' => $gigApp->id,
                'status' => 'Pending',
            ]);
        }
    }

    public function reject($user, array $input)
    {
        $gigApp = GigApplication::find($input['gig_app_id']);
        if ($gigApp !== null) {
            $gigApp->update(['status' => 'Rejected']);
            $this->createTrail($user, $gigApp);
        }
    }

    public function rejectWithComment($user, array $input)
    {
        $this->validate($input);

        $gigApp = GigApplication::find($input['gig_app_id']);
        if ($gigApp !== null) {
            $gigApp->update(['status' => 'Rejected']);
            $this->createTrail($user, $gigApp);

            $this->updateInterview($gigApp, $input['comment']);
        }
    }

    public function acceptWithComment($user, array $input)
    {
        $this->validate($input);

        $gigApp = GigApplication::with('applicant', 'gigAd')->find($input['gig_app_id']);
        if ($gigApp !== null) {
            $gigApp->update(['status' => 'Accepted']);
            $this->createTrail($user, $gigApp);

            $this->updateInterview($gigApp, $input['comment']);

            return $this->createPlaybook($gigApp);
        }
    }

    private function validate(array $input)
    {
        $customAttributes = array(
            'comment' => 'interview write-up',
        );

        Validator::make($input, [
            'comment' => ['required', 'string', 'max:4096'],
        ], [], $customAttributes)->validateWithBag('gigInterviewError');
    }

    private function createTrail($user, $gigApp)
    {
        GigApplicationTrail::create([
            'gig_app_id' => $gigApp->id,
            'updated_by_id' => $user->id,
            'trail_date' => Date::now(),
            'status' => $gigApp->status,
        ]);
    }

    private function updateInterview($gigApp, $comment)
    {
        $gigInterview = GigInterview::where('gig_app_id', $gigApp->id)->first();
        $gigInterview?->update([
            'comment' => $comment,
            'status' => 'Completed'
        ]);
    }

    private function createPlaybook($gigApp)
    {
        $gigPlaybook = GigPlaybook::create([
            'gig_host_id' => $gigApp->gigAd->user_id,
            'gigger_id' => $gigApp->applicant->id,
            'job_title' => $gigApp->gigAd->job_title,
            'job_start_date' => $gigApp->gigAd->job_start_date,
            'job_end_date' => $gigApp->gigAd->job_end_date,
            'status' => 'Pending Contract Signing'
        ]);

        GigPlaybookContract::create([
            'gig_playbook_id' => $gigPlaybook->id,
            'status' => 'Pending',
        ]);

        return $gigPlaybook;
    }
}
