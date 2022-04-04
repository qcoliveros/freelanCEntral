<?php

namespace App\Providers;

use App\Actions\Profile\ManageUserWorkExperience;
use App\Actions\Profile\UpdateUserAboutInformation;
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
