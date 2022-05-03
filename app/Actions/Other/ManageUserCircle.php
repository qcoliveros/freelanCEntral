<?php

namespace App\Actions\Other;

use App\Contracts\Other\ManagesUserCircle;
use App\Models\UserCircle;
use Illuminate\Validation\ValidationException;

class ManageUserCircle implements ManagesUserCircle
{
    /**
     * @throws ValidationException
     */
    public function followUser($user, array $input)
    {
        $userCircle = UserCircle::where([
                'user_id' => $user->id,
                'follow_user_id' => $input['follow_user_id']
            ])->first();

        if ($userCircle === null) {
            $user->circles()->create($input);
        } else {
            throw ValidationException::withMessages(['followUserError' => 'Already following the user.']);
        }
    }

    public function unfollowUser($user, array $input)
    {
        if (isset($input['follow_user_id'])) {
            UserCircle::where([
                'user_id' => $user->id,
                'follow_user_id' => $input['follow_user_id']
            ])->delete();
        }
    }
}
