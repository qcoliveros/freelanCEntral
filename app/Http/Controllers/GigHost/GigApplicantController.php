<?php

namespace App\Http\Controllers\GigHost;

use App\Contracts\GigHost\ManagesGigApplicant;
use App\Http\Controllers\Controller;
use App\Models\GigAd;
use App\Models\GigApplication;
use App\Models\GigInterview;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Laravel\Jetstream\Jetstream;

class GigApplicantController extends Controller
{
    public function index(Request $request)
    {
        return Jetstream::inertia()->render($request, 'GigHost/ShowGigApplicationList', [
            'gigAd' => GigAd::select('id', 'job_title', 'status')->where('id', $request['id'])->first(),
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
        $applicant = User::where('id', $request['user_id'])->with('phoneType')->first();
        return Jetstream::inertia()->render($request, 'GigHost/ViewGigApplicantDetail', [
            'gigAd' => GigAd::select('id', 'job_title', 'status')->where('id', $request['id'])->first(),
            'gigApp' => GigApplication::select('id', 'status')->where('id', $request['gig_app_id'])->first(),
            'applicant' => $applicant,
            'applicant.workExperiences' => $applicant->userWorkExperiences()->latest('start_date')->get(),
            'applicant.educations' => $applicant->userEducations()->latest('start_date')->get(),
            'applicant.technicalSkills' => $applicant->userTechnicalSkills()->with('skill', 'proficiency')->get(),
            'applicant.softSkills' => $applicant->userSoftSkills()->with('skill', 'proficiency')->get(),
            'applicant.languages' => $applicant->userLanguages()->with('language', 'speakingProficiency', 'writingProficiency', 'readingProficiency')->get(),
            'interviewList' => GigInterview::where('gig_app_id', $request['gig_app_id'])
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($gigApp) => [
                    'id' => $gigApp->id,
                    'interview_date' => $gigApp->interview_date,
                    'comment' => $gigApp->comment,
                    'status' => $gigApp->status,
                ]),
        ]);
    }

    public function shortlist(Request $request, ManagesGigApplicant $updater)
    {
        $updater->shortlist($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'gig-applicant-shortlisted');
    }

    public function reject(Request $request, ManagesGigApplicant $updater)
    {
        $updater->reject($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : Redirect::route('gigHost.gigApp.list', [
                    'id' => $request['id'],
                    'gig_app_id' => $request['gig_app_id'],
                    'user_id' => $request['user_id'],
                ])->with('status', 'gig-applicant-rejected');
    }
}
