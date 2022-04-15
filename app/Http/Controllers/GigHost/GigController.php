<?php

namespace App\Http\Controllers\GigHost;

use App\Http\Controllers\Controller;
use App\Models\Gig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\Jetstream;

class GigController extends Controller
{
    public function index(Request $request)
    {
        return Jetstream::inertia()->render($request, 'GigHost/GigList', [
            'gigAdList' => Gig::where('gig_host_id', $request->user()->id)
                ->orderBy(DB::raw('ISNULL(posted_date)', 'posted_date'), 'ASC')
                ->get(),
        ]);
    }
}
