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
    public function index(Request $request)
    {
        return Jetstream::inertia()->render($request, 'GigHost/ShowGigInterviewSchedule', [
            'search' => $request['search'],
            'gigAd' => GigAd::select('id', 'job_title', 'status')->where('id', $request['id'])->first(),
            'gigApp' => GigApplication::select('id', 'status')->where('id', $request['gig_app_id'])->first(),
            'applicant' => User::where('id', $request['user_id'])->first(),
            'interviewList' => GigInterview::where('gig_app_id', $request['gig_app_id'])
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

    public function schedule(Request $request, ManagesGigInterview $updater)
    {
        $updater->schedule($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'gig-interview-scheduled');
    }

    public function delete(Request $request, ManagesGigInterview $updater)
    {
        $updater->delete($request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'gig-interview-deleted');
    }

    public function submit(Request $request, ManagesGigInterview $updater)
    {
        $updater->submit($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'gig-interview-submitted');
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
