<?php

namespace App\Actions\GigHost;

use App\Contracts\GigHost\ManagesGigPlaybook;
use App\Models\GigPlaybook;
use App\Models\GigPlaybookContract;
use App\Models\GigPlaybookReview;
use App\Models\GigPlaybookTask;
use App\Models\GigPlaybookTaskComment;
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

        $this->completePlaybook($input);
    }

    public function completePlaybook(array $input)
    {
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
        $notClosedCount = $gigPlaybook->tasks->filter(function($gigTask){
            return $gigTask->status != 'Closed';
        })->count();

        if ($notClosedCount == 0) {
            $gigPlaybook->update(['status' => 'Pending Review']);
            $this->createReview($input);

            return true;
        }

        return false;
    }

    public function closePlaybook(array $input)
    {
        GigPlaybook::find($input['id'])->update(['status' => 'Closed']);
    }

    public function publishComment($user, array $input)
    {
        Validator::make($input, [
            'message' => ['required', 'string', 'max:2048'],
        ])->validateWithBag('gigPlaybookTaskCommentError');

        if (!isset($input['comment_id'])) {
            GigPlaybookTask::find($input['task_id'])->comments()->create([
                'user_id' => $user->id,
                'publish_date' => Date::now(),
                'message' => $input['message'],
            ]);
        } else {
            GigPlaybookTaskComment::find($input['comment_id'])->comments()->create([
                'gig_playbook_task_id' => $input['task_id'],
                'user_id' => $user->id,
                'publish_date' => Date::now(),
                'message' => $input['message'],
            ]);
        }
    }

    public function createReview(array $input)
    {
        $gigPlaybook = GigPlaybook::find($input['id']);
        GigPlaybookReview::create([
            'gig_playbook_id' => $gigPlaybook->id,
            'reviewer_id' => $gigPlaybook->gig_host_id,
            'reviewee_id' => $gigPlaybook->gigger_id,
            'status' => 'Draft',
        ]);
    }

    public function saveReview(array $input)
    {
        $this->validateReview($input);

        GigPlaybookReview::find($input['review_id'])->update([
            'review' => $input['review'],
        ]);
    }

    public function submitReview(array $input)
    {
        $this->validateReview($input);

        GigPlaybookReview::find($input['review_id'])->update([
            'review_date' => Date::now(),
            'review' => $input['review'],
            'status' => 'Completed',
        ]);

        $this->closePlaybook($input);
    }

    private function validateReview(array $input)
    {
        Validator::make($input, [
            'review' => ['required', 'string', 'max:4096'],
        ])->validateWithBag('gigPlaybookReviewError');
    }
}
