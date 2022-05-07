<?php

namespace App\Models;

use App\Models\Parameter\EmploymentType;
use App\Traits\HasIndustry;
use App\Traits\HasLocation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWorkExperience extends Model
{
    use HasFactory;
    use HasIndustry;
    use HasLocation;

    protected $fillable = [
        'user_id',
        'title',
        'employment_type_id',
        'company_name',
        'location_id',
        'start_date',
        'end_date',
        'is_current',
        'industry_id',
        'description',
    ];

    protected $casts = [
        'is_current' => 'boolean',
    ];

    public function employmentType()
    {
        return $this->hasOne(EmploymentType::class, 'id', 'employment_type_id');
    }
}
