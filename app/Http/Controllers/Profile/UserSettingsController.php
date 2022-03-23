<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Http\Controllers\Inertia\UserProfileController;

class UserSettingsController extends UserProfileController
{
    public function show(Request $request)
    {
        return Jetstream::inertia()->render($request, 'Settings/Show', [
            'sessions' => $this->sessions($request)->all(),
        ]);
    }
}
