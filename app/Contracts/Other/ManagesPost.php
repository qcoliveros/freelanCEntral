<?php

namespace App\Contracts\Other;

interface ManagesPost
{
    public function publishPost($user, array $input);

    public function deletePost(array $input);

    public function publishComment($user, array $input);
}
