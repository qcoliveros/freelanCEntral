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

class GigApplicationController extends Controller
{
    public function index(Request $request)
    {
        return Jetstream::inertia()->render($request, 'Gigger/ShowGigApplicationList', [
            'search' => $request['search'],
            'gigAppList' => GigApplication::where('user_id', $request->user()->id)
                ->orderByRaw("FIELD(status, 'Shortlisted', 'Submitted', 'Withdrawn') ASC,  applied_date DESC")
                ->filterByJobTitle($request['search'])
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($gigApp) => [
                    'id' => $gigApp->id,
                    'applied_date' => $gigApp->applied_date,
                    'status' => $gigApp->status,
                    'gig_ad' => $gigApp->gigAd,
                    'gig_ad.gig_host' => $gigApp->gigAd->gigHost,
                ]),
        ]);
    }

    public function view(Request $request)
    {
        $gigApp = GigApplication::where('id', $request['id'])->first();
        $gigAd = GigAd::where('id', $gigApp->gigAd->id)->with('jobFunction')->first();
        return Jetstream::inertia()->render($request, 'Gigger/ShowGigApplicationDetail', [
            'search' => $request['search'],
            'gigApp' => $gigApp,
            'gigAd' => $gigAd,
            'gigHost' => $gigApp->gigAd->gigHost,
        ]);
    }

    public function withdraw(Request $request, ManagesGigApplication $updater)
    {
        $updater->withdraw($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : Redirect::route('gigger.gigApp.list')->with('status', 'gig-app-withdraw');
    }
}
