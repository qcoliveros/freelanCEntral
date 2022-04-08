<?php

namespace App\Http\Controllers\Profile;

use App\Contracts\Profile\ManagesUserEducation;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserEducationController extends Controller
{
    public function store(Request $request, ManagesUserEducation $updater)
    {
        $updater->store($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'user-education-stored');
    }

    public function update(Request $request, ManagesUserEducation $updater)
    {
        $updater->update($request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'user-education-updated');
    }

    public function delete(Request $request, ManagesUserEducation $updater)
    {
        $updater->delete($request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'user-education-deleted');
    }
}
