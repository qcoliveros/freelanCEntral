<?php

namespace App\Contracts\Other;

interface ManagesPost
{
    public function publishPost($user, array $input);

    public function deletePost(array $input);

    public function publishComment($user, array $input);

    public function deleteComment(array $input);

    public function likePost($user, array $input);

    public function unlikePost($user, array $input);
}
