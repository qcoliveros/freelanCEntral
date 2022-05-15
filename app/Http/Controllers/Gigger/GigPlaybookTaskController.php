<?php

namespace App\Http\Controllers\Gigger;

use App\Http\Controllers\Controller;
use App\Models\GigPlaybook;
use App\Models\GigPlaybookTask;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;

class GigPlaybookTaskController extends Controller
{
    public function index(Request $request)
    {
        $gigPlaybook = GigPlaybook::find($request['id']);
        return Jetstream::inertia()->render($request, 'Gigger/ShowGigPlaybookTaskList', [
            'search' => $request['search'],
            'gigPlaybook' => $gigPlaybook,
            'gigTaskList' => GigPlaybookTask::where('gig_playbook_id', $gigPlaybook->id)
                ->whereNotIn('status', ['Draft'])
                ->orderByRaw('start_date ASC, end_date ASC, title ASC')
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($gigPlaybookTask) => [
                    'id' => $gigPlaybookTask->id,
                    'title' => $gigPlaybookTask->title,
                    'start_date' => $gigPlaybookTask->start_date,
                    'end_date' => $gigPlaybookTask->end_date,
                    'status' => $gigPlaybookTask->status,
                ]),
        ]);
    }
}
