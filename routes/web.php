<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::get('/giggerEngagementRules', function () {
    return Inertia::render('GiggerEngagementRules');
});

Route::get('/gigHostEngagementRules', function () {
    return Inertia::render('GigHostEngagementRules');
});

Route::get('/gigMasterTips', function () {
    return Inertia::render('GigMasterTips');
});

Route::group(['middleware' => 'auth'], function() {
    Route::group(['middleware' => 'role:admin', 'prefix' => 'admin', 'as' => 'admin.'], function() {
        Route::resource('userList', \App\Http\Controllers\Admin\UserController::class);
    });
    Route::group(['middleware' => 'role:gigger', 'prefix' => 'gigger', 'as' => 'gigger.'], function() {
        Route::resource('gigList', \App\Http\Controllers\Gigger\GigController::class);
    });
    Route::group(['middleware' => 'role:gigHost', 'prefix' => 'gigHost', 'as' => 'gigHost.'], function() {
        Route::resource('gigList', \App\Http\Controllers\GigHost\GigController::class);
    });
});
