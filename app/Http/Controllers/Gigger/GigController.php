<?php

namespace App\Http\Controllers\Gigger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;

class GigController extends Controller
{
    public function index(Request $request)
    {
        return Jetstream::inertia()->render($request, 'Gigger/GigList');
    }
}
