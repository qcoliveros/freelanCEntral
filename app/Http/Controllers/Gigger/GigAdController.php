<?php

namespace App\Http\Controllers\Gigger;

use App\Contracts\Gigger\ManagesGigApplication;
use App\Http\Controllers\Controller;
use App\Models\GigAd;
use App\Models\GigApplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Laravel\Jetstream\Jetstream;

class GigAdController extends Controller
{
    public function find(Request $request)
    {
        return Jetstream::inertia()->render($request, 'Gigger/ShowGigAdList', [
            'search' => $request['search'],
            'gigAdList' => GigAd::whereRaw('publish_date IS NOT NULL AND close_date IS NULL')
                ->orderByRaw('ISNULL(publish_date) DESC, job_title ASC')
                ->filterByJobTitle($request['search'] != null ? $request['search'] : $request->user())
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($gigAd) => [
                    'id' => $gigAd->id,
                    'job_title' => $gigAd->job_title,
                    'publish_date' => $gigAd->publish_date,
                    'gig_host' => $gigAd->gigHost,
                ]),
        ]);
    }

    public function view(Request $request)
    {
        $gigAd = GigAd::where('id', $request['id'])->with('jobFunction')->first();
        $gigApp = GigApplication::where([
            'user_id' => $request->user()->id,
            'gig_ad_id' => $gigAd->id,
        ])->whereNotIn(
            'status', ['Withdrawn']
        )->first();
        return Jetstream::inertia()->render($request, 'Gigger/ShowGigAdDetail', [
            'hasApplied' => $gigApp != null,
            'search' => $request['search'],
            'gigAd' => $gigAd,
            'gigHost' => $gigAd->gigHost,
        ]);
    }

    public function apply(Request $request, ManagesGigApplication $updater)
    {
        $updater->apply($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : Redirect::route('gigger.gigApp.list')->with('status', 'gig-ad-applied');
    }
}
