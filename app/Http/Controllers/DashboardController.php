<?php

namespace App\Http\Controllers;

use App\Contracts\Other\ManagesPost;
use App\Models\Post;
use App\Models\UserCircle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userCircles = UserCircle::where('user_id', $request->user()->id)->pluck('follow_user_id');
        $userCircles[] = $request->user()->id;
        return Jetstream::inertia()->render($request, 'Dashboard', [
            'postList' => Post::orderByPublishDate()
                ->filterByUser($userCircles)
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($post) => [
                    'id' => $post->id,
                    'message' => $post->message,
                    'publish_date' => $post->publish_date,
                    'user' => $post->user,
                    'comments' => $post->comments()->orderByPublishDate()->get()->map->only('id', 'user', 'message')
                ]),
        ]);
    }

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
}
