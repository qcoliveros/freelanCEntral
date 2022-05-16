<?php

namespace App\Providers;

use App\Actions\Admin\ManageParameter;
use App\Actions\Gigger\ManageGigApplication;
use App\Actions\GigHost\ManageGigAd;
use App\Actions\GigHost\ManageGigApplicant;
use App\Actions\GigHost\ManageGigInterview;
use App\Actions\GigHost\ManageGigPlaybook;
use App\Actions\Other\ManagePost;
use App\Actions\Other\ManageUserCircle;
use App\Actions\Profile\ManageUserEducation;
use App\Actions\Profile\ManageUserLanguage;
use App\Actions\Profile\ManageUserSoftSkill;
use App\Actions\Profile\ManageUserTechnicalSkill;
use App\Actions\Profile\ManageUserWorkExperience;
use App\Actions\Profile\UpdateUserAboutInformation;
use App\Contracts\Admin\ManagesParameter;
use App\Contracts\Gigger\ManagesGigApplication;
use App\Contracts\GigHost\ManagesGigAd;
use App\Contracts\GigHost\ManagesGigApplicant;
use App\Contracts\GigHost\ManagesGigInterview;
use App\Contracts\GigHost\ManagesGigPlaybook;
use App\Contracts\Other\ManagesPost;
use App\Contracts\Other\ManagesUserCircle;
use App\Contracts\Profile\ManagesUserEducation;
use App\Contracts\Profile\ManagesUserLanguage;
use App\Contracts\Profile\ManagesUserSoftSkill;
use App\Contracts\Profile\ManagesUserTechnicalSkill;
use App\Contracts\Profile\ManagesUserWorkExperience;
use App\Contracts\Profile\UpdatesUserAboutInformation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UpdatesUserAboutInformation::class, UpdateUserAboutInformation::class);
        $this->app->bind(ManagesUserWorkExperience::class, ManageUserWorkExperience::class);
        $this->app->bind(ManagesUserEducation::class, ManageUserEducation::class);
        $this->app->bind(ManagesUserTechnicalSkill::class, ManageUserTechnicalSkill::class);
        $this->app->bind(ManagesUserSoftSkill::class, ManageUserSoftSkill::class);
        $this->app->bind(ManagesUserLanguage::class, ManageUserLanguage::class);

        $this->app->bind(ManagesParameter::class, ManageParameter::class);

        $this->app->bind(ManagesGigAd::class, ManageGigAd::class);
        $this->app->bind(ManagesGigApplication::class, ManageGigApplication::class);
        $this->app->bind(ManagesGigApplicant::class, ManageGigApplicant::class);
        $this->app->bind(ManagesGigInterview::class, ManageGigInterview::class);
        $this->app->bind(ManagesGigPlaybook::class, ManageGigPlaybook::class);

        $this->app->bind(ManagesPost::class, ManagePost::class);
        $this->app->bind(ManagesUserCircle::class, ManageUserCircle::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
