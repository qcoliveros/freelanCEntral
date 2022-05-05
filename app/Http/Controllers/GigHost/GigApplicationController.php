<?php

namespace App\Http\Controllers\GigHost;

use App\Http\Controllers\Controller;
use App\Models\GigAd;
use App\Models\GigApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;

class GigApplicationController extends Controller
{
    public function index(Request $request)
    {
        return Jetstream::inertia()->render($request, 'GigHost/ShowGigApplicationList', [
            'gigAd' => GigAd::select('id', 'job_title')->where('id', $request['id'])->first(),
            'gigAppList' => GigApplication::where('gig_ad_id', $request['id'])
                ->whereNotIn('status', ['Withdrawn'])
                ->orderBy('applied_date')
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($gigApp) => [
                    'id' => $gigApp->id,
                    'applied_date' => $gigApp->applied_date,
                    'status' => $gigApp->status,
                    'applicant' => $gigApp->applicant,
                ]),
        ]);
    }

    public function view(Request $request)
    {
        return Jetstream::inertia()->render($request, 'GigHost/ViewApplicantDetail', [
            'gigAd' => GigAd::select('id', 'job_title')->where('id', $request['id'])->first(),
            'gigApp' => GigApplication::select('id', 'status')->where('id', $request['gig_app_id'])->first(),
            'applicant' => User::where('id', $request['user_id'])->with('phoneType')->first(),
        ]);
    }
}
