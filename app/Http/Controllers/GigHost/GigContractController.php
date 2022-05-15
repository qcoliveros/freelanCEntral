<?php

namespace App\Http\Controllers\GigHost;

use App\Contracts\GigHost\ManagesGigPlaybook;
use App\Http\Controllers\Controller;
use App\Models\GigPlaybook;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Laravel\Jetstream\Jetstream;

class GigContractController extends Controller
{
    public function view(Request $request)
    {
        $gigPlaybook = GigPlaybook::find($request['id']);
        return Jetstream::inertia()->render($request, 'GigHost/ShowGigContractDetail', [
            'search' => $request['search'],
            'gigPlaybook' => $gigPlaybook,
            'gigContract' => $gigPlaybook->contract,
        ]);
    }

    public function save(Request $request, ManagesGigPlaybook $updater)
    {
        $updater->saveContract($request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'gig-playbook-contract-save');
    }

    public function send(Request $request, ManagesGigPlaybook $updater)
    {
        $updater->sendContract($request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : Redirect::route('gigHost.gigPlaybook.list', [
                'search' => $request['search']
            ])->with('status', 'gig-playbook-contract-send');
    }
}
