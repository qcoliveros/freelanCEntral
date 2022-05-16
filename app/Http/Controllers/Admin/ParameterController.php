<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;

class ParameterController extends Controller
{
    public function index(Request $request)
    {
        return Jetstream::inertia()->render($request, 'Admin/ParameterList', [
            'parameterList' => [
                0 => ['name' => 'Country'],
                1 => ['name' => 'Duration'],
                2 => ['name' => 'Employment Type'],
                3 => ['name' => 'Industry'],
                4 => ['name' => 'Job Function'],
                5 => ['name' => 'Language'],
                6 => ['name' => 'Language Proficiency'],
                7 => ['name' => 'Messenger Type'],
                8 => ['name' => 'Phone Type'],
                9 => ['name' => 'Skill Proficiency'],
                10 => ['name' => 'Soft Skill'],
                11 => ['name' => 'Technical Skill'],
            ],
        ]);
    }
}
