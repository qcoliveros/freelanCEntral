<?php

namespace App\Http\Controllers\Gigger;

use App\Http\Controllers\Controller;
use App\Models\GigAd;
use App\Models\GigApplication;
use App\Models\GigInterview;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;

class GigInterviewController extends Controller
{
    public function index(Request $request)
    {
        $gigApp = GigApplication::find($request['id']);
        return Jetstream::inertia()->render($request, 'Gigger/ShowGigInterviewSchedule', [
            'gigAd' => GigAd::select('id', 'job_title', 'status')->where('id', $gigApp->gig_ad_id)->first(),
            'gigApp' => $gigApp,
            'applicant' => User::where('id', $gigApp->user_id)->first(),
            'interviewList' => GigInterview::where('gig_app_id', $gigApp->id)
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($gigApp) => [
                    'id' => $gigApp->id,
                    'interview_date' => $gigApp->interview_date,
                    'comment' => $gigApp->comment,
                    'status' => $gigApp->status,
                ]),
        ]);
    }
}
