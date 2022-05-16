<?php

namespace App\Http\Controllers\GigHost;

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
        return Jetstream::inertia()->render($request, 'GigHost/ShowGigPlaybookTaskList', [
            'search' => $request['search'],
            'gigPlaybook' => $gigPlaybook,
            'gigTaskList' => GigPlaybookTask::where('gig_playbook_id', $gigPlaybook->id)
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

    public function create(Request $request)
    {
        return Jetstream::inertia()->render($request, 'GigHost/ManageGigPlaybookTaskDetail', [
            'search' => $request['search'],
            'gigPlaybook' => GigPlaybook::find($request['id']),
            'isEdit' => false,
        ]);
    }

    public function edit(Request $request)
    {
        $gigTask = GigPlaybookTask::find($request['task_id']);
        return Jetstream::inertia()->render($request, 'GigHost/ManageGigPlaybookTaskDetail', [
            'search' => $request['search'],
            'gigPlaybook' => GigPlaybook::find($request['id']),
            'gigTask' => $gigTask,
            'gigTaskComments' => $gigTask != null
                ? GigPlaybookTaskComment::where('gig_playbook_task_id', $gigTask->id)->with('comments')->get() : [],
            'isEdit' => true,
        ]);
    }

    public function view(Request $request)
    {
        $gigTask = GigPlaybookTask::find($request['task_id']);
        return Jetstream::inertia()->render($request, 'GigHost/ViewGigPlaybookTaskDetail', [
            'search' => $request['search'],
            'gigPlaybook' => GigPlaybook::find($request['id']),
            'gigTask' => $gigTask,
            'gigTaskComments' => $gigTask != null
                ? GigPlaybookTaskComment::where('gig_playbook_task_id', $gigTask->id)
                    ->whereNull('gig_playbook_task_comment_id')
                    ->with('user', 'comments', 'comments.user')
                    ->get()
                : [],
        ]);
    }

    public function save(Request $request, ManagesGigPlaybook $updater)
    {
        $updater->saveTask($request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : Redirect::route('gigHost.gigPlaybook.viewTasks', [
                'id' => $request['id']
            ])->with('status', 'gig-playbook-task-saved');
    }

    public function delete(Request $request, ManagesGigPlaybook $updater)
    {
        $updater->deleteTask($request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'gig-playbook-task-deleted');
    }

    public function submit(Request $request, ManagesGigPlaybook $updater)
    {
        $updater->submitTasks($request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : Redirect::route('gigHost.gigPlaybook.list', [
                'search' => $request['search']
            ])->with('status', 'gig-playbook-tasks-submitted');
    }

    public function close(Request $request, ManagesGigPlaybook $updater)
    {
        $updater->closeTask($request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'gig-playbook-task-closed');
    }
}
