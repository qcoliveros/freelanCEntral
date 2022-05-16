<?php

namespace App\Models;

use App\Traits\HasCircles;
use App\Traits\HasContacts;
use App\Traits\HasEducations;
use App\Traits\HasGigAds;
use App\Traits\HasGigApplications;
use App\Traits\HasIndustry;
use App\Traits\HasLanguages;
use App\Traits\HasPostComments;
use App\Traits\HasPosts;
use App\Traits\HasSoftSkills;
use App\Traits\HasTechnicalSkills;
use App\Traits\HasWorkExperiences;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use HasContacts;
    use HasIndustry;
    use HasWorkExperiences;
    use HasEducations;
    use HasTechnicalSkills;
    use HasSoftSkills;
    use HasLanguages;
    use HasPosts;
    use HasPostComments;
    use HasCircles;
    use HasGigAds;
    use HasGigApplications;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'phone_type_id',
        'messenger',
        'messenger_type_id',
        'website_url',
        'industry_id',
        'about',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function scopeFilterByName($query, $filter)
    {
        $query->when($filter ?? null, function ($query, $search) {
            $query->where('name', 'LIKE', '%'.$search.'%');
        });
    }
}
