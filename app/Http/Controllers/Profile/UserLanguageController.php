<?php

namespace App\Http\Controllers\Profile;

use App\Contracts\Profile\ManagesUserLanguage;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserLanguageController extends Controller
{
    public function store(Request $request, ManagesUserLanguage $updater)
    {
        $updater->store($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'user-language-stored');
    }

    public function update(Request $request, ManagesUserLanguage $updater)
    {
        $updater->update($request->user(), $request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'user-language-updated');
    }

    public function delete(Request $request, ManagesUserLanguage $updater)
    {
        $updater->delete($request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'user-language-deleted');
    }
}
