<?php

namespace App\Actions\Other;

use App\Contracts\Other\ManagesPost;
use App\Models\Post;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;

class ManagePost implements ManagesPost
{
    public function publishPost($user, array $input)
    {
        Validator::make($input, [
            'message' => ['required', 'string', 'max:2048'],
        ])->validateWithBag('postError');

        $input['publish_date'] = Date::now();

        if (!isset($input['id'])) {
            $user->posts()->create($input);
        } else {
            Post::find($input['id'])->update($input);
        }
    }

    public function deletePost(array $input)
    {
        if (isset($input['id'])) {
            Post::find($input['id'])->delete();
        }
    }

    public function publishComment($user, array $input)
    {
        Validator::make($input, [
            'comment' => ['required', 'string', 'max:2048'],
        ])->validateWithBag('postCommentError');

        $input['publish_date'] = Date::now();
        $input['user_id'] = $user->id;

        Post::find($input['id'])->comments()->create($input);
    }
}
