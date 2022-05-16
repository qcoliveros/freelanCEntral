<?php

namespace App\Http\Controllers\GigHost;

use App\Contracts\GigHost\ManagesGigPlaybook;
use App\Http\Controllers\Controller;
use App\Models\GigPlaybook;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Laravel\Jetstream\Jetstream;

class GigReviewController extends Controller
{
    public function view(Request $request)
    {
        $gigPlaybook = GigPlaybook::with('review', 'review.reviewer', 'review.reviewee')->find($request['id']);
        return Jetstream::inertia()->render($request, 'GigHost/ShowGigReviewDetail', [
            'search' => $request['search'],
            'gigPlaybook' => $gigPlaybook,
            'gigReview' => $gigPlaybook->review,
        ]);
    }

    public function save(Request $request, ManagesGigPlaybook $updater)
    {
        $updater->saveReview($request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'gig-playbook-review-save');
    }

    public function submit(Request $request, ManagesGigPlaybook $updater)
    {
        $updater->submitReview($request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : Redirect::route('gigHost.gigPlaybook.list', [
                'search' => $request['search']
            ])->with('status', 'gig-playbook-review-submit');
    }
}
