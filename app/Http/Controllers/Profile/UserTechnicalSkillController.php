<?php

namespace App\Http\Controllers\Profile;

use App\Contracts\Profile\ManagesUserTechnicalSkill;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserTechnicalSkillController extends Controller
{
    public function store(Request $request, ManagesUserTechnicalSkill $updater)
    {
        $updater->store($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'user-technical-skill-stored');
    }

    public function update(Request $request, ManagesUserTechnicalSkill $updater)
    {
        $updater->update($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'user-technical-skill-updated');
    }

    public function delete(Request $request, ManagesUserTechnicalSkill $updater)
    {
        $updater->delete($request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'user-technical-skill-deleted');
    }
}
