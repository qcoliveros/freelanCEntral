<?php

namespace App\Http\Controllers\Profile;

use App\Contracts\Profile\ManagesUserWorkExperience;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserWorkExperienceController extends Controller
{
    public function store(Request $request, ManagesUserWorkExperience $updater)
    {
        $updater->store($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'work-experience-stored');
    }

    public function update(Request $request, ManagesUserWorkExperience $updater)
    {
        $updater->update($request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'work-experience-updated');
    }

    public function delete(Request $request, ManagesUserWorkExperience $updater)
    {
        $updater->delete($request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'work-experience-deleted');
    }
}
