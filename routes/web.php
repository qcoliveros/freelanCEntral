<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Other\UserPageController;
use App\Http\Controllers\Shared\GigPlaybookTaskCommentController;
use App\Http\Controllers\Shared\PostController;
use App\Http\Controllers\Profile\UserAboutInformationController;
use App\Http\Controllers\Profile\UserEducationController;
use App\Http\Controllers\Profile\UserLanguageController;
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

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/own-page-view', [UserPageController::class, 'viewOwn'])
        ->name('own-page.view');
    Route::get('/user-page-view', [UserPageController::class, 'view'])
        ->name('user-page.view');
    Route::post('/user-page-follow', [UserPageController::class, 'follow'])
        ->name('user-page.follow');
    Route::post('/user-page-unfollow', [UserPageController::class, 'unfollow'])
        ->name('user-page.unfollow');

    Route::post('/post', [PostController::class, 'publishPost'])
        ->name('post.publish');
    Route::post('/post-comment', [PostController::class, 'publishComment'])
        ->name('post-comment.publish');
    Route::post('/post-like', [PostController::class, 'likePost'])
        ->name('post.like');
    Route::post('/post-unlike', [PostController::class, 'unlikePost'])
        ->name('post.unlike');

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

    Route::post('/task-comment', [GigPlaybookTaskCommentController::class, 'publishComment'])
        ->name('gig-task-comment.publish');

    Route::group(['middleware' => 'role:Administrator', 'prefix' => 'admin', 'as' => 'admin.'], function() {
        Route::get('user-list', [\App\Http\Controllers\Admin\UserController::class, 'index'])
            ->name('user.list');

        Route::get('parameter-list', [\App\Http\Controllers\Admin\ParameterController::class, 'index'])
            ->name('parameter.list');
    });

    Route::group(['middleware' => 'role:Gigger', 'prefix' => 'gigger', 'as' => 'gigger.'], function() {
        Route::get('gig-ad-find', [\App\Http\Controllers\Gigger\GigAdController::class, 'find'])
            ->name('gigAd.find');
        Route::get('gig-ad-view', [\App\Http\Controllers\Gigger\GigAdController::class, 'view'])
            ->name('gigAd.view');
        Route::post('gig-ad-apply', [\App\Http\Controllers\Gigger\GigAdController::class, 'apply'])
            ->name('gigAd.apply');

        Route::get('gig-app-list', [\App\Http\Controllers\Gigger\GigApplicationController::class, 'index'])
            ->name('gigApp.list');
        Route::get('gig-app-view', [\App\Http\Controllers\Gigger\GigApplicationController::class, 'view'])
            ->name('gigApp.view');
        Route::post('gig-app-withdraw', [\App\Http\Controllers\Gigger\GigApplicationController::class, 'withdraw'])
            ->name('gigApp.withdraw');

        Route::get('gig-interview-view', [\App\Http\Controllers\Gigger\GigInterviewController::class, 'view'])
            ->name('gigInterview.view');
        Route::post('gig-interview-accept-sched', [\App\Http\Controllers\Gigger\GigInterviewController::class, 'acceptSchedule'])
            ->name('gigInterview.acceptSchedule');
        Route::post('gig-interview-reject-sched', [\App\Http\Controllers\Gigger\GigInterviewController::class, 'rejectSchedule'])
            ->name('gigInterview.rejectSchedule');
        Route::post('gig-interview-submit', [\App\Http\Controllers\Gigger\GigInterviewController::class, 'submit'])
            ->name('gigInterview.submit');

        Route::get('gig-playbook-list', [\App\Http\Controllers\Gigger\GigPlaybookController::class, 'index'])
            ->name('gigPlaybook.list');

        Route::get('gig-playbook-view-contract', [\App\Http\Controllers\Gigger\GigContractController::class, 'view'])
            ->name('gigPlaybook.viewContract');
        Route::post('gig-playbook-accept-contract', [\App\Http\Controllers\Gigger\GigContractController::class, 'accept'])
            ->name('gigPlaybook.acceptContract');
        Route::post('gig-playbook-reject-contract', [\App\Http\Controllers\Gigger\GigContractController::class, 'reject'])
            ->name('gigPlaybook.rejectContract');

        Route::get('gig-playbook-task-list', [\App\Http\Controllers\Gigger\GigPlaybookTaskController::class, 'index'])
            ->name('gigPlaybook.viewTasks');
        Route::get('gig-playbook-view-task', [\App\Http\Controllers\Gigger\GigPlaybookTaskController::class, 'view'])
            ->name('gigPlaybook.viewTask');
        Route::post('gig-playbook-start-task', [\App\Http\Controllers\Gigger\GigPlaybookTaskController::class, 'start'])
            ->name('gigPlaybook.startTask');
        Route::post('gig-playbook-hold-task', [\App\Http\Controllers\Gigger\GigPlaybookTaskController::class, 'hold'])
            ->name('gigPlaybook.holdTask');
        Route::post('gig-playbook-complete-task', [\App\Http\Controllers\Gigger\GigPlaybookTaskController::class, 'complete'])
            ->name('gigPlaybook.completeTask');

        Route::get('gig-playbook-view-review', [\App\Http\Controllers\Gigger\GigReviewController::class, 'view'])
            ->name('gigPlaybook.viewReview');
    });

    Route::group(['middleware' => 'role:Gig Host', 'prefix' => 'gigHost', 'as' => 'gigHost.'], function() {
        Route::get('gig-ad-list', [\App\Http\Controllers\GigHost\GigAdController::class, 'index'])
            ->name('gigAd.list');
        Route::get('gig-ad-create', [\App\Http\Controllers\GigHost\GigAdController::class, 'create'])
            ->name('gigAd.create');
        Route::get('gig-ad-edit', [\App\Http\Controllers\GigHost\GigAdController::class, 'edit'])
            ->name('gigAd.edit');
        Route::get('gig-ad-view', [\App\Http\Controllers\GigHost\GigAdController::class, 'view'])
            ->name('gigAd.view');
        Route::post('gig-ad-save', [\App\Http\Controllers\GigHost\GigAdController::class, 'save'])
            ->name('gigAd.save');
        Route::post('gig-ad-publish', [\App\Http\Controllers\GigHost\GigAdController::class, 'publish'])
            ->name('gigAd.publish');
        Route::post('gig-ad-close', [\App\Http\Controllers\GigHost\GigAdController::class, 'close'])
            ->name('gigAd.close');
        Route::delete('gig-ad-delete', [\App\Http\Controllers\GigHost\GigAdController::class, 'delete'])
            ->name('gigAd.delete');

        Route::get('gig-app-list', [\App\Http\Controllers\GigHost\GigApplicantController::class, 'index'])
            ->name('gigApp.list');
        Route::get('gig-applicant-view', [\App\Http\Controllers\GigHost\GigApplicantController::class, 'view'])
            ->name('gigApplicant.view');
        Route::post('gig-applicant-shortlist', [\App\Http\Controllers\GigHost\GigApplicantController::class, 'shortlist'])
            ->name('gigApplicant.shortlist');
        Route::post('gig-applicant-reject', [\App\Http\Controllers\GigHost\GigApplicantController::class, 'reject'])
            ->name('gigApplicant.reject');

        Route::get('gig-interview-view', [\App\Http\Controllers\GigHost\GigInterviewController::class, 'view'])
            ->name('gigInterview.view');
        Route::post('gig-interview-create-sched', [\App\Http\Controllers\GigHost\GigInterviewController::class, 'createSchedule'])
            ->name('gigInterview.createSchedule');
        Route::post('gig-interview-delete-sched', [\App\Http\Controllers\GigHost\GigInterviewController::class, 'deleteSchedule'])
            ->name('gigInterview.deleteSchedule');
        Route::post('gig-interview-send-invite', [\App\Http\Controllers\GigHost\GigInterviewController::class, 'sendInvite'])
            ->name('gigInterview.sendInvite');

        Route::post('gig-interview-accept-applicant', [\App\Http\Controllers\GigHost\GigInterviewController::class, 'acceptApplicant'])
            ->name('gigInterview.acceptApplicant');
        Route::post('gig-interview-reject-applicant', [\App\Http\Controllers\GigHost\GigInterviewController::class, 'rejectApplicant'])
            ->name('gigInterview.rejectApplicant');

        Route::get('gig-playbook-list', [\App\Http\Controllers\GigHost\GigPlaybookController::class, 'index'])
            ->name('gigPlaybook.list');

        Route::get('gig-playbook-view-contract', [\App\Http\Controllers\GigHost\GigContractController::class, 'view'])
            ->name('gigPlaybook.viewContract');
        Route::post('gig-playbook-save-contract', [\App\Http\Controllers\GigHost\GigContractController::class, 'save'])
            ->name('gigPlaybook.saveContract');
        Route::post('gig-playbook-send-contract', [\App\Http\Controllers\GigHost\GigContractController::class, 'send'])
            ->name('gigPlaybook.sendContract');

        Route::get('gig-playbook-task-list', [\App\Http\Controllers\GigHost\GigPlaybookTaskController::class, 'index'])
            ->name('gigPlaybook.viewTasks');
        Route::post('gig-playbook-submit-tasks', [\App\Http\Controllers\GigHost\GigPlaybookTaskController::class, 'submit'])
            ->name('gigPlaybook.submitTasks');
        Route::get('gig-playbook-create-task', [\App\Http\Controllers\GigHost\GigPlaybookTaskController::class, 'create'])
            ->name('gigPlaybook.createTask');
        Route::get('gig-playbook-edit-task', [\App\Http\Controllers\GigHost\GigPlaybookTaskController::class, 'edit'])
            ->name('gigPlaybook.editTask');
        Route::get('gig-playbook-view-task', [\App\Http\Controllers\GigHost\GigPlaybookTaskController::class, 'view'])
            ->name('gigPlaybook.viewTask');
        Route::delete('gig-playbook-delete-task', [\App\Http\Controllers\GigHost\GigPlaybookTaskController::class, 'delete'])
            ->name('gigPlaybook.deleteTask');
        Route::post('gig-playbook-save-task', [\App\Http\Controllers\GigHost\GigPlaybookTaskController::class, 'save'])
            ->name('gigPlaybook.saveTask');
        Route::post('gig-playbook-close-task', [\App\Http\Controllers\GigHost\GigPlaybookTaskController::class, 'close'])
            ->name('gigPlaybook.closeTask');

        Route::get('gig-playbook-view-review', [\App\Http\Controllers\GigHost\GigReviewController::class, 'view'])
            ->name('gigPlaybook.viewReview');
        Route::post('gig-playbook-save-contract', [\App\Http\Controllers\GigHost\GigReviewController::class, 'save'])
            ->name('gigPlaybook.saveReview');
        Route::post('gig-playbook-submit-contract', [\App\Http\Controllers\GigHost\GigReviewController::class, 'submit'])
            ->name('gigPlaybook.submitReview');
    });
});
