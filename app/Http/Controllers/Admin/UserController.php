<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return Jetstream::inertia()->render($request, 'Admin/UserList');
    }
}
