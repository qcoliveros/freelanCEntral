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
            'interview_start' => ['required', 'date_format:Y-m-d H:i:s', 'after:now',
                Rule::unique('gig_interview_schedules', 'interview_start')->where(
                    function ($query) use ($gigInterviewId) {
                        return $query->where('gig_interview_id', $gigInterviewId);
                    })
                ],
            'interview_end' => ['required', 'date_format:Y-m-d H:i:s', 'after:interview_start'],
        ])->validateWithBag('gigInterviewScheduleError');

        if (!isset($input['schedule_id'])) {
            GigInterview::find($gigInterviewId)->schedules()->create([
                'created_by' => $input['user_id'],
                'interview_start' => $input['interview_start'],
                'interview_end' => $input['interview_end'],
                'status' => 'Draft'
            ]);
        } else {
            GigInterviewSchedule::find($input['interview_id'])->update([
                'interview_start' => $input['interview_start'],
                'interview_end' => $input['interview_end'],
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
