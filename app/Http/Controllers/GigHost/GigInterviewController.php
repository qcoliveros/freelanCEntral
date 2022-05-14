<?php

namespace App\Http\Controllers\GigHost;

use App\Contracts\GigHost\ManagesGigInterview;
use App\Http\Controllers\Controller;
use App\Models\GigAd;
use App\Models\GigApplication;
use App\Models\GigInterview;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;

class GigInterviewController extends Controller
{
    public function view(Request $request)
    {
        return Jetstream::inertia()->render($request, 'GigHost/ShowGigInterviewDetail', [
            'search' => $request['search'],
            'gigAd' => GigAd::select('id', 'job_title', 'status')->where('id', $request['id'])->first(),
            'gigApp' => GigApplication::select('id', 'status')->where('id', $request['gig_app_id'])->first(),
            'applicant' => User::where('id', $request['user_id'])->first(),
            'interview' => GigInterview::where('gig_app_id', $request['gig_app_id'])->with('schedules')->first(),
        ]);
    }

    public function createSchedule(Request $request, ManagesGigInterview $updater)
    {
        $updater->createSchedule($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'gig-interview-schedule-created');
    }

    public function deleteSchedule(Request $request, ManagesGigInterview $updater)
    {
        $updater->deleteSchedule($request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'gig-interview-schedule-deleted');
    }

    public function sendInvite(Request $request, ManagesGigInterview $updater)
    {
        $updater->sendInvite($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'gig-interview-invite-sent');
    }

    public function accept(Request $request, ManagesGigInterview $updater)
    {
        $updater->accept($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'gig-interview-accepted');
    }

    public function reject(Request $request, ManagesGigInterview $updater)
    {
        $updater->reject($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'gig-interview-rejected');
    }
}
