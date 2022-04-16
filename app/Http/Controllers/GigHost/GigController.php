<?php

namespace App\Http\Controllers\GigHost;

use App\Contracts\GigHost\ManagesGig;
use App\Http\Controllers\Controller;
use App\Models\Gig;
use App\Models\Parameter\Duration;
use App\Models\Parameter\JobFunction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\Jetstream;

class GigController extends Controller
{
    public function index(Request $request)
    {
        return Jetstream::inertia()->render($request, 'GigHost/GigList', [
            'gigAdList' => Gig::where('user_id', $request->user()->id)
                ->orderBy(DB::raw('ISNULL(posted_date)', 'posted_date'), 'ASC')
                ->get(),
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
            'gigAd' => Gig::where('id', $request->input['id'])->get(),
        ]);
    }

    public function store(Request $request, ManagesGig $updater)
    {
        $updater->store($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : Route::route('gigHost.gig.list')->with('status', 'gig-ad-stored');
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
