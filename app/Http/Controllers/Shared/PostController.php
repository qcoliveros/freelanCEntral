<?php

namespace App\Http\Controllers\Shared;

use App\Contracts\Other\ManagesPost;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostLike;
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

    protected function setupProps($post, $userId)
    {
        return [
            'id' => $post->id,
            'message' => $post->message,
            'publish_date' => $post->publish_date,
            'user' => $post->user,
            'likes_count' => PostLike::where('post_id', $post->id)->whereNull('post_comment_id')->count(),
            'like_indicator' => PostLike::where('post_id', $post->id)
                    ->whereNull('post_comment_id')
                    ->where('user_id', $userId)
                    ->first() != null,
            'comments' => $post->comments()->orderByPublishDate()->get()->map->only('id', 'user', 'message')
        ];
    }
}
