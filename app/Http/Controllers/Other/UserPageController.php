<?php

namespace App\Http\Controllers\Other;

use App\Contracts\Other\ManagesUserCircle;
use App\Http\Controllers\Shared\PostController;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\User;
use App\Models\UserCircle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;

class UserPageController extends PostController
{
    public function viewOwn(Request $request)
    {
        return Jetstream::inertia()->render($request, 'Other/DisplayUserPage', [
            'isOwn' => true,
            'gigHost' => User::find($request->user()->id),
            'postList' => Post::where('user_id', $request->user()->id)
                ->orderByPublishDate()
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($post) => $this->setupProps($post, $request->user()->id)),
        ]);
    }

    public function view(Request $request)
    {
        $userCircle = UserCircle::where([
            'user_id' => $request->user()->id,
            'follow_user_id' => $request['user_id']
        ])->first();

        return Jetstream::inertia()->render($request, 'Other/DisplayUserPage', [
            'isOwn' => false,
            'isFollowing' => $userCircle != null,
            'gigHost' => User::find($request['user_id']),
            'postList' => Post::where('user_id', $request['user_id'])
                ->orderByPublishDate()
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($post) => $this->setupProps($post, $request->user()->id)),
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
