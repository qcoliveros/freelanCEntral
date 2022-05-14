<?php

namespace App\Actions\GigHost;

use App\Contracts\GigHost\ManagesGigApplicant;
use App\Models\GigApplication;
use App\Models\GigApplicationTrail;
use App\Models\GigInterview;
use Illuminate\Support\Facades\Date;

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
            $this->updateInterviewComment($gigApp, $input['comment']);
            $this->createTrail($user, $gigApp);
        }
    }

    public function accept($user, array $input)
    {
        $gigApp = GigApplication::find($input['gig_app_id']);
        if ($gigApp !== null) {
            $gigApp->update(['status' => 'Accepted']);
            $this->updateInterviewComment($gigApp, $input['comment']);
            $this->createTrail($user, $gigApp);
        }
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

    private function updateInterviewComment($gigApp, $comment)
    {
        if (isset($comment)) {
            $gigInterview = GigInterview::where('gig_app_id', $gigApp->id)->first();
            if ($gigInterview != null) {
                $gigInterview->update(['comment', $comment]);
            }
        }
    }
}
