<?php

namespace App\Actions\GigHost;

use App\Contracts\GigHost\ManagesGigPlaybook;
use App\Models\GigPlaybook;
use App\Models\GigPlaybookContract;
use App\Models\GigPlaybookTask;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;

class ManageGigPlaybook implements ManagesGigPlaybook
{
    public function saveContract(array $input)
    {
        $this->validateContract($input);

        GigPlaybookContract::find($input['contract_id'])->update($input);
    }

    public function sendContract(array $input)
    {
        $this->validateContract($input);

        GigPlaybookContract::find($input['contract_id'])->update([
            'clause' => $input['clause'],
            'status' => 'Pending'
        ]);
    }

    public function rejectContract(array $input)
    {
        GigPlaybookContract::find($input['contract_id'])->update([
            'status' => 'Rejected'
        ]);

        GigPlaybook::find($input['id'])->update([
            'status' => 'Contract Rejected'
        ]);
    }

    public function acceptContract(array $input)
    {
        GigPlaybookContract::find($input['contract_id'])->update([
            'status' => 'Accepted',
            'signed_date' => Date::now(),
        ]);

        GigPlaybook::find($input['id'])->update([
            'status' => 'Contract Accepted'
        ]);
    }

    private function validateContract(array $input)
    {
        $customAttributes = array(
            'clause' => 'contract',
        );

        Validator::make($input, [
            'clause' => ['required', 'string', 'max:4096'],
        ], [], $customAttributes)->validateWithBag('gigContractError');
    }

    public function saveTask(array $input)
    {
        $this->validateTask($input);
        $this->createOrUpdateTask($input);
    }

    private function validateTask(array $input)
    {
        Validator::make($input, [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:4096'],
            'start_date' => ['required', 'date', 'after:now'],
            'end_date' => ['required', 'date', 'after:start_date'],
        ])->validateWithBag('gigPlaybookTaskError');
    }

    private function createOrUpdateTask(array $input)
    {
        if (!isset($input['task_id'])) {
            $input['status'] = 'Draft';
            GigPlaybook::find($input['id'])->tasks()->create($input);
        } else {
            GigPlaybookTask::find($input['task_id'])->update($input);
        }
    }

    public function deleteTask(array $input)
    {
        if (isset($input['task_id'])) {
            GigPlaybookTask::find($input['task_id'])->delete();
        }
    }

    public function submitTasks(array $input)
    {
        $gigPlaybook = GigPlaybook::with('tasks')->find($input['id']);
        $gigPlaybook->update(['status' => 'In Progress']);

        $gigTasks = $gigPlaybook->tasks;
        if ($gigTasks != null) {
            foreach ($gigTasks as $gigTask) {
                if ($gigTask->status == 'Draft') {
                    $gigTask->update(['status' => 'Open']);
                }
            }
        }
    }

    public function startTask(array $input)
    {
        if (isset($input['task_id'])) {
            GigPlaybookTask::find($input['task_id'])->update([
                'status' => 'In Progress'
            ]);
        }
    }

    public function holdTask(array $input)
    {
        if (isset($input['task_id'])) {
            GigPlaybookTask::find($input['task_id'])->update([
                'status' => 'On-hold'
            ]);
        }
    }

    public function completeTask(array $input)
    {
        if (isset($input['task_id'])) {
            GigPlaybookTask::find($input['task_id'])->update([
                'status' => 'Completed'
            ]);
        }

        $gigPlaybook = GigPlaybook::with('tasks')->find($input['id']);
        $notCompletedCount = $gigPlaybook->tasks->filter(function($gigTask){
            return !in_array($gigTask->status, ['Completed','Closed']);
        })->count();

        if ($notCompletedCount == 0) {
            $gigPlaybook->update(['status' => 'Completed']);
        }
    }

    public function closeTask(array $input)
    {
        if (isset($input['task_id'])) {
            GigPlaybookTask::find($input['task_id'])->update([
                'status' => 'Closed'
            ]);
        }

        $gigPlaybook = GigPlaybook::with('tasks')->find($input['id']);
        $notCompletedCount = $gigPlaybook->tasks->filter(function($gigTask){
            return $gigTask->status != 'Closed';
        })->count();

        if ($notCompletedCount == 0) {
            $gigPlaybook->update(['status' => 'Closed']);
        }
    }
}
