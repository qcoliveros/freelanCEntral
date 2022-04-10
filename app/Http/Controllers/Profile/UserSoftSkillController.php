<?php

namespace App\Http\Controllers\Profile;

use App\Contracts\Profile\ManagesUserSoftSkill;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserSoftSkillController extends Controller
{
    public function store(Request $request, ManagesUserSoftSkill $updater)
    {
        $updater->store($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'user-soft-skill-stored');
    }

    public function update(Request $request, ManagesUserSoftSkill $updater)
    {
        $updater->update($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'user-soft-skill-updated');
    }

    public function delete(Request $request, ManagesUserSoftSkill $updater)
    {
        $updater->delete($request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'user-soft-skill-deleted');
    }
}
