<?php

namespace App\Actions\GigHost;

use App\Contracts\GigHost\ManagesGigApplicant;
use App\Models\GigApplication;
use App\Models\GigApplicationTrail;
use Illuminate\Support\Facades\Date;

class ManageGigApplicant implements ManagesGigApplicant
{
    public function shortlist($user, array $input)
    {
        $gigApp = GigApplication::find($input['gig_app_id']);

        if ($gigApp !== null) {
            $gigApp->update(['status' => 'Shortlisted']);

            $this->insertTrail($user, $gigApp);
        }
    }

    public function reject($user, array $input)
    {
        $gigApp = GigApplication::find($input['gig_app_id']);

        if ($gigApp !== null) {
            $gigApp->update(['status' => 'Rejected']);

            $this->insertTrail($user, $gigApp);
        }
    }

    private function insertTrail($user, $gigApp)
    {
        GigApplicationTrail::create([
            'gig_app_id' => $gigApp->id,
            'updated_by_id' => $user->id,
            'trail_date' => Date::now(),
            'status' => $gigApp->status,
        ]);
    }
}
