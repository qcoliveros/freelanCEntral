<?php

namespace App\Http\Controllers\Shared;

use App\Contracts\Other\ManagesPost;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function publishPost(Request $request, ManagesPost $updater)
    {
        $updater->publishPost($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'post-published');
    }

    public function publishComment(Request $request, ManagesPost $updater)
    {
        $updater->publishComment($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'post-comment-published');
    }

    public function likePost(Request $request, ManagesPost $updater)
    {
        $updater->likePost($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'post-liked');
    }

    public function unlikePost(Request $request, ManagesPost $updater)
    {
        $updater->unlikePost($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'post-unliked');
    }
}
