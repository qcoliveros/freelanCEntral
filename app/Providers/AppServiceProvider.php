<?php

namespace App\Providers;

use App\Actions\Profile\ManageUserSoftSkill;
use App\Actions\Profile\UpdateUserAboutInformation;
use App\Actions\Profile\ManageUserEducation;
use App\Actions\Profile\ManageUserTechnicalSkill;
use App\Actions\Profile\ManageUserWorkExperience;
use App\Contracts\Profile\ManagesUserSoftSkill;
use App\Contracts\Profile\UpdatesUserAboutInformation;
use App\Contracts\Profile\ManagesUserEducation;
use App\Contracts\Profile\ManagesUserTechnicalSkill;
use App\Contracts\Profile\ManagesUserWorkExperience;
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
