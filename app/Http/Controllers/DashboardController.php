<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Shared\PostController;
use App\Models\Post;
use App\Models\UserCircle;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;

class DashboardController extends PostController
{
    public function index(Request $request)
    {
        $userCircles = null;
        if (!$request->user()->hasRole('Administrator')) {
            $userCircles = UserCircle::where('user_id', $request->user()->id)->pluck('follow_user_id');
            $userCircles[] = $request->user()->id;
        }

        return Jetstream::inertia()->render($request, 'Dashboard', [
            'postList' => Post::orderByPublishDate()
                ->filterByUser($userCircles)
                ->paginate(5)
                ->withQueryString()
                ->through(fn ($post) => $this->setupProps($post, $request->user()->id)),
        ]);
    }
}
