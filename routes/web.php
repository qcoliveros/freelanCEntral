<?php

use App\Http\Controllers\Profile\UserSettingsController;
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

Route::get('/giggerEngagementRules', function () {
    return Inertia::render('GiggerEngagementRules');
});

Route::get('/gigHostEngagementRules', function () {
    return Inertia::render('GigHostEngagementRules');
});

Route::get('/gigMasterTips', function () {
    return Inertia::render('GigMasterTips');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/user/settings', [UserSettingsController::class, 'show'])->name('settings.show');

    Route::group(['middleware' => 'role:Administrator', 'prefix' => 'admin', 'as' => 'admin.'], function() {
        Route::get('userList', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('user.list');
    });
    Route::group(['middleware' => 'role:Gigger', 'prefix' => 'gigger', 'as' => 'gigger.'], function() {
        Route::get('gigList', [\App\Http\Controllers\Gigger\GigController::class, 'index'])->name('gig.list');
    });
    Route::group(['middleware' => 'role:Gig Host', 'prefix' => 'gigHost', 'as' => 'gigHost.'], function() {
        Route::get('gigList', [\App\Http\Controllers\GigHost\GigController::class, 'index'])->name('gig.list');
    });
});
