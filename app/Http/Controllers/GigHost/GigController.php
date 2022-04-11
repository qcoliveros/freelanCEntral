<?php

namespace App\Http\Controllers\GigHost;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;

class GigController extends Controller
{
    public function index(Request $request)
    {
        return Jetstream::inertia()->render($request, 'GigHost/GigList', [
            'gigAdList' => [],
        ]);
    }
}
