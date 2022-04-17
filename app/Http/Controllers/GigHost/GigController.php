<?php

namespace App\Http\Controllers\GigHost;

use App\Contracts\GigHost\ManagesGig;
use App\Http\Controllers\Controller;
use App\Models\Gig;
use App\Models\Parameter\Duration;
use App\Models\Parameter\JobFunction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Laravel\Jetstream\Jetstream;

class GigController extends Controller
{
    public function index(Request $request)
    {
        return Jetstream::inertia()->render($request, 'GigHost/GigList', [
            'gigAdList' => Gig::where('user_id', $request->user()->id)
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
        return Jetstream::inertia()->render($request, 'GigHost/GigDetail', [
            'parameter.jobFunctions' => JobFunction::pluck('name', 'id'),
            'parameter.durations' => Duration::pluck('name', 'id'),
        ]);
    }

    public function edit(Request $request)
    {
        return Jetstream::inertia()->render($request, 'GigHost/GigDetail', [
            'parameter.jobFunctions' => JobFunction::pluck('name', 'id'),
            'parameter.durations' => Duration::pluck('name', 'id'),

            'gigAd' => Gig::where('id', $request->input['id'])->get(),
        ]);
    }

    public function store(Request $request, ManagesGig $updater)
    {
        $updater->store($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : Redirect::route('gigHost.gig.list')->with('status', 'gig-ad-stored');
    }

    public function update(Request $request, ManagesGig $updater)
    {
        $updater->update($request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'gig-ad-updated');
    }

    public function delete(Request $request, ManagesGig $updater)
    {
        $updater->delete($request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'gig-ad-deleted');
    }
}
