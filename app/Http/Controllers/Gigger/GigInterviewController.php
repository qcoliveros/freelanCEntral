<?php

namespace App\Http\Controllers\Gigger;

use App\Contracts\GigHost\ManagesGigInterview;
use App\Http\Controllers\Controller;
use App\Models\GigAd;
use App\Models\GigApplication;
use App\Models\GigInterview;
use App\Models\GigInterviewSchedule;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;

class GigInterviewController extends Controller
{
    public function view(Request $request)
    {
        $gigApp = GigApplication::find($request['id']);
        $gigInterview = GigInterview::where('gig_app_id', $gigApp->id)->whereNotIn('status', ['Pending'])->first();
        return Jetstream::inertia()->render($request, 'Gigger/ShowGigInterviewDetail', [
            'gigAd' => GigAd::select('id', 'job_title', 'status')->where('id', $gigApp->gig_ad_id)->first(),
            'gigApp' => $gigApp,
            'applicant' => User::where('id', $gigApp->user_id)->first(),
            'interview' => $gigInterview,
            'interview.schedules' => GigInterviewSchedule::where('gig_interview_id', $gigInterview->id)->whereNotIn('status', ['Draft'])->get(),
        ]);
    }

    public function acceptSchedule(Request $request, ManagesGigInterview $updater)
    {
        $updater->acceptSchedule($request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'gig-interview-schedule-accepted');
    }

    public function rejectSchedule(Request $request, ManagesGigInterview $updater)
    {
        $updater->rejectSchedule($request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'gig-interview-schedule-accepted');
    }

    public function submit(Request $request, ManagesGigInterview $updater)
    {
        $updater->confirmInterview($request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'gig-interview-confirmed');
    }
}
