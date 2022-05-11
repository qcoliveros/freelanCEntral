<?php

namespace App\Actions\Other;

use App\Contracts\Other\ManagesPost;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostLike;
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
            'message' => ['required', 'string', 'max:2048'],
        ])->validateWithBag('postCommentError');

        $input['user_id'] = $user->id;
        $input['publish_date'] = Date::now();

        if (!isset($input['id'])) {
            Post::find($input['post_id'])->comments()->create($input);
        } else {
            PostComment::find($input['id'])->update($input);
        }
    }

    public function deleteComment(array $input)
    {
        if (isset($input['id'])) {
            PostComment::find($input['id'])->delete();
        }
    }

    public function likePost($user, array $input)
    {
        $input['user_id'] = $user->id;
        $input['like_date'] = Date::now();

        if (!isset($input['id'])) {
            Post::find($input['post_id'])->likes()->create($input);
        } else {
            PostLike::find($input['id'])->update($input);
        }
    }

    public function unlikePost($user, array $input)
    {
        $input['user_id'] = $user->id;
        Post::find($input['post_id'])->likes()->delete($input);
    }
}
