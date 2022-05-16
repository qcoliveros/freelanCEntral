<?php

namespace App\Http\Controllers\Shared;

use App\Contracts\GigHost\ManagesGigPlaybook;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GigPlaybookTaskCommentController extends Controller
{
    public function publishComment(Request $request, ManagesGigPlaybook $updater)
    {
        $updater->publishComment($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'gig-task-comment-published');
    }
}
