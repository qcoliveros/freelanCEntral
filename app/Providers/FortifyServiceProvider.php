<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\Parameter\Country;
use App\Models\Parameter\EmploymentType;
use App\Models\Parameter\Industry;
use App\Models\Parameter\MessengerType;
use App\Models\Parameter\PhoneType;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use Laravel\Jetstream\Jetstream;
use Spatie\Permission\Models\Role;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::registerView(function () {
            return Inertia::render('Auth/Register', [
                'parameter.roles' => Role::all()->whereNotIn('name', 'Administrator')->pluck('name', 'id'),
            ]);
        });

        if (Features::enabled(Features::updateProfileInformation())) {
            Jetstream::inertia()->whenRendering(
                'Profile/Show',
                function (Request $request, array $data) {
                    return array_merge($data, [
                        'parameter.phoneTypes' => PhoneType::all()->pluck('name', 'id'),
                        'parameter.messengerTypes' => MessengerType::all()->pluck('name', 'id'),
                        'parameter.employmentTypes' => EmploymentType::all()->pluck('name', 'id'),
                        'parameter.countries' => Country::all()->pluck('name', 'id'),
                        'parameter.industries' => Industry::all()->pluck('name', 'id'),

                        'user.workExperiences' => $request->user()->userWorkExperiences()->get(),
                        'user.educations' => $request->user()->userEducations()->get(),
                    ]);
                }
            );
        }
    }
}
