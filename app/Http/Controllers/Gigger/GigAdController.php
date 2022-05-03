<?php

namespace App\Http\Controllers\Gigger;

use App\Http\Controllers\Controller;
use App\Models\GigAd;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;

class GigAdController extends Controller
{
    public function find(Request $request)
    {
        return Jetstream::inertia()->render($request, 'Gigger/ShowGigAdList',[
            'search' => $request['search'],
            'gigAdList' => GigAd::whereRaw('publish_date IS NOT NULL AND close_date IS NULL')
                ->orderByRaw('ISNULL(publish_date) DESC, job_title ASC')
                ->filterByJobTitle($request['search'] != null ? $request['search'] : $request->user())
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($gigAd) => [
                    'id' => $gigAd->id,
                    'job_title' => $gigAd->job_title,
                    'description' => $gigAd->description,
                    'job_function' => $gigAd->jobFunction->name,
                    'other_job_function' => $gigAd->other_job_function,
                    'commitment_time' => $gigAd->commitment_time,
                    'job_start_date' => $gigAd->job_start_date,
                    'job_end_date' => $gigAd->job_end_date,
                    'publish_date' => $gigAd->publish_date,
                    'gig_host' => $gigAd->gigHost,
                ]),
        ]);
    }
}
