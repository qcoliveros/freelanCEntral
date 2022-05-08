<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GigApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gig_ad_id',
        'applied_date',
        'status',
    ];

    public function applicant()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function gigAd()
    {
        return $this->belongsTo(GigAd::class, 'gig_ad_id', 'id');
    }

    public function trails()
    {
        return $this->hasMany(GigApplicationTrail::class);
    }

    public function interviews()
    {
        return $this->hasMany(GigInterview::class);
    }
}
