<?php

namespace App\Http\Controllers\Gigger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;

class GigAdController extends Controller
{
    public function find(Request $request)
    {
        return Jetstream::inertia()->render($request, 'Gigger/FindGigAd');
    }
}
