<?php

namespace App\Http\Controllers;

use App\Contracts\Other\ManagesUserCircle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserCircleController extends Controller
{
    public function followUser(Request $request, ManagesUserCircle $updater)
    {
        $updater->followUser($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'user-followed');
    }

    public function unfollowUser(Request $request, ManagesUserCircle $updater)
    {
        $updater->unfollowUser($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'user-unfollowed');
    }
}
