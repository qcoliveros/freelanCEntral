<?php

namespace App\Traits;

use App\Models\PostComment;

trait HasPostComments
{
    public function postComments()
    {
        return $this->hasMany(PostComment::class);
    }
}
