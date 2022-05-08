<?php

namespace App\Http\Controllers\GigHost;

use App\Contracts\GigHost\ManagesGigInterview;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GigInterviewController extends Controller
{
    public function submit(Request $request, ManagesGigInterview $updater)
    {
        $updater->schedule($request->user(), $request->all());

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
