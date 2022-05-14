<?php

namespace App\Actions\GigHost;

use App\Contracts\GigHost\ManagesGigInterview;
use App\Models\GigApplication;
use App\Models\GigInterview;
use App\Models\GigInterviewSchedule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ManageGigInterview implements ManagesGigInterview
{
    public function createSchedule($user, array $input)
    {
        $gigInterviewId = $input['interview_id'];
        Validator::make($input, [
            'interview_date' => ['required', 'date', 'after:now',
                Rule::unique('gig_interview_schedules', 'interview_date')->where(
                    function ($query) use ($gigInterviewId) {
                        return $query->where('gig_interview_id', $gigInterviewId);
                    })
                ],
        ])->validateWithBag('gigInterviewScheduleError');

        if (!isset($input['schedule_id'])) {
            GigInterview::find($gigInterviewId)->schedules()->create([
                'created_by' => $input['user_id'],
                'interview_date' => $input['interview_date'],
                'status' => 'Draft'
            ]);
        } else {
            GigInterviewSchedule::find($input['interview_id'])->update([
                'interview_date' => $input['interview_date'],
            ]);
        }
    }

    public function deleteSchedule(array $input)
    {
        if (isset($input['schedule_id'])) {
            GigInterviewSchedule::find($input['schedule_id'])->delete();
        }
    }

    public function sendInvite($user, array $input)
    {
        $gigInterview = GigInterview::find($input['interview_id']);

        if ($gigInterview != null) {
            $gigInterview->update([
                'status' => 'Sent Invite',
            ]);

            $gigInterviewScheduleList = GigInterviewSchedule::where('gig_interview_id', $input['interview_id'])->get();
            if ($gigInterviewScheduleList != null) {
                foreach ($gigInterviewScheduleList as $gigInterviewSchedule) {
                    if ($gigInterviewSchedule->status == 'Draft') {
                        $gigInterviewSchedule->update(['status' => 'Sent']);
                    }
                }
            }
        }
    }
}
