<?php

namespace App\Http\Controllers\Gigger;

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
        return Jetstream::inertia()->render($request, 'Gigger/ShowGigContractDetail', [
            'search' => $request['search'],
            'gigPlaybook' => $gigPlaybook,
            'gigContract' => $gigPlaybook->contract,
        ]);
    }

    public function accept(Request $request, ManagesGigPlaybook $updater)
    {
        $updater->acceptContract($request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : Redirect::route('gigger.gigPlaybook.list', [
                'search' => $request['search']
            ])->with('status', 'gig-playbook-contract-accepted');
    }

    public function reject(Request $request, ManagesGigPlaybook $updater)
    {
        $updater->rejectContract($request->all());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : Redirect::route('gigger.gigPlaybook.list', [
                'search' => $request['search']
            ])->with('status', 'gig-playbook-contract-rejected');
    }
}
