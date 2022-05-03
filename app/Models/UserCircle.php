<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCircle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'follow_user_id',
    ];

    public function followUser()
    {
        return $this->hasOne(User::class, 'id', 'follow_user_id');
    }
}
