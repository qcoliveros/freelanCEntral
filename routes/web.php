<?php

use App\Http\Controllers\Profile\UserAboutInformationController;
use App\Http\Controllers\Profile\UserEducationController;
use \App\Http\Controllers\Profile\UserLanguageController;
use App\Http\Controllers\Profile\UserSettingsController;
use App\Http\Controllers\Profile\UserSoftSkillController;
use App\Http\Controllers\Profile\UserTechnicalSkillController;
use App\Http\Controllers\Profile\UserWorkExperienceController;
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

Route::get('/gigger/engagement-rules', function () {
    return Inertia::render('Gigger/EngagementRules');
});

Route::get('/gigHost/engagement-rules', function () {
    return Inertia::render('GigHost/EngagementRules');
});

Route::get('/gig-master-tips', function () {
    return Inertia::render('GigMasterTips');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/user/settings', [UserSettingsController::class, 'show'])
        ->name('settings.show');
    // User's About Information
    Route::post('/user/about-information', [UserAboutInformationController::class, 'update'])
        ->name('user-about-information.update');
    // User's Work Experience
    Route::post('/user/add-work-experience', [UserWorkExperienceController::class, 'store'])
        ->name('user-work-experience.store');
    Route::post('/user/edit-work-experience', [UserWorkExperienceController::class, 'update'])
        ->name('user-work-experience.update');
    Route::delete('/user/delete-work-experience', [UserWorkExperienceController::class, 'delete'])
        ->name('user-work-experience.delete');
    // User's Education
    Route::post('/user/add-education', [UserEducationController::class, 'store'])
        ->name('user-education.store');
    Route::post('/user/edit-education', [UserEducationController::class, 'update'])
        ->name('user-education.update');
    Route::delete('/user/delete-education', [UserEducationController::class, 'delete'])
        ->name('user-education.delete');
    // User's Technical Skill
    Route::post('/user/add-technical-skill', [UserTechnicalSkillController::class, 'store'])
        ->name('user-technical-skill.store');
    Route::post('/user/edit-technical-skill', [UserTechnicalSkillController::class, 'update'])
        ->name('user-technical-skill.update');
    Route::delete('/user/delete-technical-skill', [UserTechnicalSkillController::class, 'delete'])
        ->name('user-technical-skill.delete');
    // User's Soft Skill
    Route::post('/user/add-soft-skill', [UserSoftSkillController::class, 'store'])
        ->name('user-soft-skill.store');
    Route::post('/user/edit-soft-skill', [UserSoftSkillController::class, 'update'])
        ->name('user-soft-skill.update');
    Route::delete('/user/delete-soft-skill', [UserSoftSkillController::class, 'delete'])
        ->name('user-soft-skill.delete');
    // User's Language
    Route::post('/user/add-language', [UserLanguageController::class, 'store'])
        ->name('user-language.store');
    Route::post('/user/edit-language', [UserLanguageController::class, 'update'])
        ->name('user-language.update');
    Route::delete('/user/delete-soft-skill', [UserLanguageController::class, 'delete'])
        ->name('user-language.delete');

    Route::group(['middleware' => 'role:Administrator', 'prefix' => 'admin', 'as' => 'admin.'], function() {
        Route::get('user-list', [\App\Http\Controllers\Admin\UserController::class, 'index'])
            ->name('user.list');
    });

    Route::group(['middleware' => 'role:Gigger', 'prefix' => 'gigger', 'as' => 'gigger.'], function() {
        Route::get('gig-list', [\App\Http\Controllers\Gigger\GigController::class, 'index'])
            ->name('gig.list');
    });

    Route::group(['middleware' => 'role:Gig Host', 'prefix' => 'gigHost', 'as' => 'gigHost.'], function() {
        Route::get('gig-list', [\App\Http\Controllers\GigHost\GigController::class, 'index'])
            ->name('gig.list');
        Route::get('gig-create', [\App\Http\Controllers\GigHost\GigController::class, 'create'])
            ->name('gig.create');
        Route::post('gig-store', [\App\Http\Controllers\GigHost\GigController::class, 'store'])
            ->name('gig.store');
        Route::get('gig-edit', [\App\Http\Controllers\GigHost\GigController::class, 'edit'])
            ->name('gig.edit');
        Route::post('gig-update', [\App\Http\Controllers\GigHost\GigController::class, 'update'])
            ->name('gig.update');
        Route::delete('gig-delete', [\App\Http\Controllers\GigHost\GigController::class, 'delete'])
            ->name('gig.delete');
    });
});
