<?php

namespace App\Actions\Gigger;

use App\Contracts\Gigger\ManagesGigApplication;
use App\Models\GigApplication;
use App\Models\GigApplicationTrail;
use Illuminate\Support\Facades\Date;

class ManageGigApplication implements ManagesGigApplication
{
    public function apply($user, array $input)
    {
        $gigApp = GigApplication::where([
            'user_id' => $user->id,
            'gig_ad_id' => $input['gig_ad_id']
        ])->first();

        if ($gigApp === null) {
            $input['applied_date'] = Date::now();
            $input['status'] = 'Submitted';

            $gigApp = $user->gigApplications()->create($input);

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
