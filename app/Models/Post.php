<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'message',
        'publish_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }

    public function scopeOrderByPublishDate($query)
    {
        $query->orderByDesc('publish_date')->orderByDesc('id');
    }
}
