<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Admin\ManagesParameter;
use App\Http\Controllers\Controller;
use App\Models\Parameter\Industry;
use App\Models\Parameter\JobFunction;
use App\Models\Parameter\MessengerType;
use App\Models\Parameter\PhoneType;
use App\Models\Parameter\SoftSkill;
use App\Models\Parameter\TechnicalSkill;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;

class ParameterController extends Controller
{
    public function index(Request $request)
    {
        $name = null;
        $parameters = [];
        $hasDescription = false;
        $pagination = 5;

        switch($request['idx']) {
            case 0:
                $name = 'Industry';
                $parameters = Industry::orderBy('name')
                    ->filterByName($request['search'])
                    ->paginate($pagination)
                    ->withQueryString()
                    ->through(fn ($parameter) => [
                        'id' => $parameter->id,
                        'name' => $parameter->name,
                    ]);
                break;
            case 1:
                $name = 'Job Function';
                $parameters = JobFunction::orderBy('name')
                    ->filterByName($request['search'])
                    ->paginate($pagination)
                    ->withQueryString()
                    ->through(fn ($parameter) => [
                        'id' => $parameter->id,
                        'name' => $parameter->name,
                    ]);
                break;
            case 2:
                $name = 'Messenger Type';
                $parameters = MessengerType::orderBy('name')
                    ->filterByName($request['search'])
                    ->paginate($pagination)
                    ->withQueryString()
                    ->through(fn ($parameter) => [
                        'id' => $parameter->id,
                        'name' => $parameter->name,
                    ]);
                break;
            case 3:
                $name = 'Phone Type';
                $parameters = PhoneType::orderBy('name')
                    ->filterByName($request['search'])
                    ->paginate($pagination)
                    ->withQueryString()
                    ->through(fn ($parameter) => [
                        'id' => $parameter->id,
                        'name' => $parameter->name,
                    ]);
                break;
            case 4:
                $name = 'Soft Skill';
                $parameters = SoftSkill::orderBy('name')
                    ->filterByName($request['search'])
                    ->paginate($pagination)
                    ->withQueryString()
                    ->through(fn ($parameter) => [
                        'id' => $parameter->id,
                        'name' => $parameter->name,
                        'description' => $parameter->description,
                    ]);
                $hasDescription = true;
                break;
            case 5:
                $name = 'Technical Skill';
                $parameters = TechnicalSkill::orderBy('name')
                    ->filterByName($request['search'])
                    ->paginate($pagination)
                    ->withQueryString()
                    ->through(fn ($parameter) => [
                        'id' => $parameter->id,
                        'name' => $parameter->name,
                        'description' => $parameter->description,
                    ]);
                $hasDescription = true;
                break;
        }

        return Jetstream::inertia()->render($request, 'Admin/ParameterList', [
            'idx' => $request['idx'],
            'search' => $request['search'],
            'hasDescription' => $hasDescription,
            'parameterName' => $name,
            'parameterItemList' => $parameters,
        ]);
    }

    public function save(Request $request, ManagesParameter $updater)
    {
        switch($request['idx']) {
            case 0:
                $updater->saveIndustry($request->user(), $request->all());
                break;
            case 1:
                $updater->saveJobFunction($request->user(), $request->all());
                break;
            case 2:
                $updater->saveMessengerType($request->user(), $request->all());
                break;
            case 3:
                $updater->savePhoneType($request->user(), $request->all());
                break;
            case 4:
                $updater->saveSoftSkill($request->user(), $request->all());
                break;
            case 5:
                $updater->saveTechnicalSkill($request->user(), $request->all());
                break;
        }

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'parameter-saved');
    }
}
