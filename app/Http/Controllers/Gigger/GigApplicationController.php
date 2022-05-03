<?php

namespace App\Http\Controllers\Gigger;

use App\Contracts\Gigger\ManagesGigApplication;
use App\Http\Controllers\Controller;
use App\Models\GigApplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;

class GigApplicationController extends Controller
{
    public function index(Request $request)
    {
        return Jetstream::inertia()->render($request, 'Gigger/ShowGigApplicationList', [
            'gigAppList' => GigApplication::where('user_id', $request->user()->id)
                ->orderByDesc('applied_date')
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

    public function apply(Request $request, ManagesGigApplication $updater)
    {
        $updater->apply($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'gig-ad-applied');
    }

    public function withdraw(Request $request, ManagesGigApplication $updater)
    {
        $updater->withdraw($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'gig-app-withdraw');
    }
}
