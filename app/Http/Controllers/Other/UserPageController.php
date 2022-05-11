<?php

namespace App\Http\Controllers\Other;

use App\Contracts\Other\ManagesUserCircle;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\User;
use App\Models\UserCircle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;

class UserPageController extends Controller
{
    public function view(Request $request)
    {
        $userCircle = UserCircle::where([
            'user_id' => $request->user()->id,
            'follow_user_id' => $request['user_id']
        ])->first();
        return Jetstream::inertia()->render($request, 'Other/DisplayUserPage', [
            'isFollowing' => $userCircle != null,
            'gigHost' => User::find($request['user_id']),
            'postList' => Post::where('user_id', $request['user_id'])
                ->orderByPublishDate()
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($post) => [
                    'id' => $post->id,
                    'message' => $post->message,
                    'publish_date' => $post->publish_date,
                    'user' => $post->user,
                    'likes_count' => PostLike::where('post_id', $post->id)->whereNull('post_comment_id')->count(),
                    'like_indicator' => PostLike::where('post_id', $post)
                            ->whereNull('post_comment_id')
                            ->where('user_id', $request->user()->id)
                            ->first() != null,
                    'comments' => $post->comments()->orderByPublishDate()->get()->map->only('id', 'user', 'message')
                ]),
        ]);
    }

    public function follow(Request $request, ManagesUserCircle $updater)
    {
        $updater->followUser($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'user-followed');
    }

    public function unfollow(Request $request, ManagesUserCircle $updater)
    {
        $updater->unfollowUser($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'user-unfollowed');
    }
}
