<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return Jetstream::inertia()->render($request, 'Admin/UserList', [
            'search' => $request['search'],
            'userList' => User::with('roles')
                ->orderBy('name')
                ->filterByName($request['search'])
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($user) => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'roles' => $user->roles,
                ]),
        ]);
    }
}
