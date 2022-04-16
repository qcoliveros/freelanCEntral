<?php

namespace App\Http\Controllers\GigHost;

use App\Http\Controllers\Controller;
use App\Models\Gig;
use App\Models\Parameter\Duration;
use App\Models\Parameter\JobFunction;
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

    public function create(Request $request)
    {
        return Jetstream::inertia()->render($request, 'GigHost/GigDetail', [
            'parameter.jobFunctions' => JobFunction::pluck('name', 'id'),
            'parameter.durations' => Duration::pluck('name', 'id'),
        ]);
    }

    public function edit(Request $request)
    {
        return Jetstream::inertia()->render($request, 'GigHost/GigDetail', [
            'gigAd' => Gig::where('id')->get(),
        ]);
    }

    public function store(Request $request)
    {

    }

    public function update(Request $request)
    {

    }

    public function delete(Request $request)
    {

    }
}
