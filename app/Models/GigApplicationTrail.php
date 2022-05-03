<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GigApplicationTrail extends Model
{
    use HasFactory;

    protected $fillable = [
        'gig_app_id',
        'updated_by_id',
        'trail_date',
        'status',
    ];

    public function gigApp()
    {
        return $this->belongsTo(GigApplication::class, 'gig_app_id', 'id');
    }

    public function updatedBy()
    {
        return $this->hasOne(User::class, 'id', 'update_by_id');
    }
}
