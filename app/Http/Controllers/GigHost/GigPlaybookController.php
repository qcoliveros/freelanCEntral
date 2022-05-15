<?php

namespace App\Http\Controllers\GigHost;

use App\Http\Controllers\Controller;
use App\Models\GigPlaybook;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;

class GigPlaybookController extends Controller
{
    public function index(Request $request)
    {
        return Jetstream::inertia()->render($request, 'GigHost/ShowGigPlaybookList', [
            'search' => $request['search'],
            'gigPlaybookList' => GigPlaybook::where('gig_host_id', $request->user()->id)
                ->orderByRaw('ISNULL(job_start_date) DESC, job_title ASC')
                ->filterByJobTitle($request['search'])
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($gigPlaybook) => [
                    'id' => $gigPlaybook->id,
                    'job_title' => $gigPlaybook->job_title,
                    'job_start_date' => $gigPlaybook->job_start_date,
                    'job_end_date' => $gigPlaybook->job_end_date,
                    'publish_date' => $gigPlaybook->publish_date,
                    'close_date' => $gigPlaybook->close_date,
                    'status' => $gigPlaybook->status,
                    'gigger' => $gigPlaybook->gigger,
                ]),
        ]);
    }
}
