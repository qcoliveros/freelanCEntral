<?php

namespace App\Http\Controllers\GigHost;

use App\Contracts\GigHost\ManagesGigAd;
use App\Http\Controllers\Controller;
use App\Models\GigAd;
use App\Models\Parameter\Duration;
use App\Models\Parameter\JobFunction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Laravel\Jetstream\Jetstream;

class GigAdController extends Controller
{
    public function index(Request $request)
    {
        return Jetstream::inertia()->render($request, 'GigHost/GigAdList', [
            'gigAdList' => GigAd::where('user_id', $request->user()->id)
                ->orderByRaw('ISNULL(posted_date) DESC')
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($gigAdList) => [
                    'id' => $gigAdList->id,
                    'job_title' => $gigAdList->job_title,
                    'job_start_date' => $gigAdList->job_start_date,
                    'job_end_date' => $gigAdList->job_end_date,
                    'posted_date' => $gigAdList->posted_date,
                ]),
        ]);
    }

    public function create(Request $request)
    {
        return Jetstream::inertia()->render($request, 'GigHost/GigAdDetail', [
            'parameter.jobFunctions' => JobFunction::pluck('name', 'id'),
            'parameter.durations' => Duration::pluck('name', 'id'),

            'isEdit' => false,
        ]);
    }

    public function store(Request $request, ManagesGigAd $updater)
    {
        $updater->store($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : Redirect::route('gigHost.gigAd.list')->with('status', 'gig-ad-stored');
    }

    public function edit(Request $request)
    {
        return Jetstream::inertia()->render($request, 'GigHost/GigAdDetail', [
            'parameter.jobFunctions' => JobFunction::pluck('name', 'id'),
            'parameter.durations' => Duration::pluck('name', 'id'),

            'gigAd' => GigAd::where('id', $request['id'])->first(),
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, ManagesGigAd $updater)
    {
        $updater->update($request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'gig-ad-updated');
    }

    public function delete(Request $request, ManagesGigAd $updater)
    {
        $updater->delete($request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : Redirect::route('gigHost.gigAd.list')->with('status', 'gig-ad-deleted');
    }
}
