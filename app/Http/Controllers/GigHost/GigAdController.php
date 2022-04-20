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
        return Jetstream::inertia()->render($request, 'GigHost/ShowGigAdList', [
            'gigAdList' => GigAd::where('user_id', $request->user()->id)
                ->orderByRaw('ISNULL(publish_date) DESC')
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($gigAdList) => [
                    'id' => $gigAdList->id,
                    'job_title' => $gigAdList->job_title,
                    'job_start_date' => $gigAdList->job_start_date,
                    'job_end_date' => $gigAdList->job_end_date,
                    'publish_date' => $gigAdList->publish_date,
                    'close_date' => $gigAdList->close_date,
                ]),
        ]);
    }

    public function create(Request $request)
    {
        return Jetstream::inertia()->render($request, 'GigHost/ManageGigAdDetail', [
            'parameter.jobFunctions' => JobFunction::pluck('name', 'id'),
            'parameter.durations' => Duration::pluck('name', 'id'),

            'isEdit' => false,
        ]);
    }

    public function edit(Request $request)
    {
        return Jetstream::inertia()->render($request, 'GigHost/ManageGigAdDetail', [
            'parameter.jobFunctions' => JobFunction::pluck('name', 'id'),
            'parameter.durations' => Duration::pluck('name', 'id'),

            'gigAd' => GigAd::where('id', $request['id'])->first(),
            'isEdit' => true,
        ]);
    }

    public function view(Request $request)
    {
        return Jetstream::inertia()->render($request, 'GigHost/ViewGigAdDetail', [
            'parameter.jobFunctions' => JobFunction::pluck('name', 'id'),
            'parameter.durations' => Duration::pluck('name', 'id'),

            'gigAd' => GigAd::where('id', $request['id'])->with('jobFunction')->first(),
        ]);
    }

    public function save(Request $request, ManagesGigAd $updater)
    {
        $updater->save($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : Redirect::route('gigHost.gigAd.list')->with('status', 'gig-ad-saved');
    }

    public function publish(Request $request, ManagesGigAd $updater)
    {
        $updater->publish($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : Redirect::route('gigHost.gigAd.list')->with('status', 'gig-ad-published');
    }

    public function close(Request $request, ManagesGigAd $updater)
    {
        $updater->close($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : Redirect::route('gigHost.gigAd.list')->with('status', 'gig-ad-closed');
    }

    public function delete(Request $request, ManagesGigAd $updater)
    {
        $updater->delete($request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : Redirect::route('gigHost.gigAd.list')->with('status', 'gig-ad-deleted');
    }
}