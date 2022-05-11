<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Shared\PostController;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\UserCircle;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;

class DashboardController extends PostController
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
                    'likes_count' => PostLike::where('post_id', $post->id)->whereNull('post_comment_id')->count(),
                    'like_indicator' => PostLike::where('post_id', $post->id)
                            ->whereNull('post_comment_id')
                            ->where('user_id', $request->user()->id)
                            ->first() != null,
                    'comments' => $post->comments()->orderByPublishDate()->get()->map->only('id', 'user', 'message')
                ]),
        ]);
    }
}
