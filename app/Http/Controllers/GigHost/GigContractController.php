<?php

namespace App\Http\Controllers\GigHost;

use App\Http\Controllers\Controller;
use App\Models\GigPlaybook;
use App\Models\GigPlaybookContract;
use Illuminate\Http\Request;
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
}
