<?php

namespace App\Http\Controllers\Gigger;

use App\Contracts\GigHost\ManagesGigPlaybook;
use App\Http\Controllers\Controller;
use App\Models\GigPlaybook;
use App\Models\GigPlaybookTask;
use App\Models\GigPlaybookTaskComment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
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

    public function view(Request $request)
    {
        $gigTask = GigPlaybookTask::find($request['task_id']);
        return Jetstream::inertia()->render($request, 'Gigger/ManageGigPlaybookTaskDetail', [
            'search' => $request['search'],
            'gigPlaybook' => GigPlaybook::find($request['id']),
            'gigTask' => $gigTask,
            'gigTaskComments' => $gigTask != null
                ? GigPlaybookTaskComment::where('gig_playbook_task_id', $gigTask->id)
                    ->whereNull('gig_playbook_task_comment_id')->with('comments')->get() : [],
        ]);
    }

    public function start(Request $request, ManagesGigPlaybook $updater)
    {
        $updater->startTask($request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'gig-playbook-task-started');
    }

    public function hold(Request $request, ManagesGigPlaybook $updater)
    {
        $updater->holdTask($request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'gig-playbook-task-held');
    }

    public function complete(Request $request, ManagesGigPlaybook $updater)
    {
        $updater->completeTask($request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'gig-playbook-task-completed');
    }
}
