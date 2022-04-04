<?php

namespace App\Http\Controllers\Profile;

use App\Contracts\Profile\UpdatesUserAboutInformation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserAboutInformationController extends Controller
{
    public function update(Request $request,
                           UpdatesUserAboutInformation $updater)
    {
        $updater->update($request->user(), $request->all());

        return $request->wantsJson()
                    ? new JsonResponse('', 200)
                    : back()->with('status', 'about-information-updated');
    }
}
