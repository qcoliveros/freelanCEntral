<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GigPlaybookTaskComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'gig_playbook_task_id',
        'gig_playbook_task_comment_id',
        'user_id',
        'message',
        'publish_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function task()
    {
        return $this->belongsTo(GigPlaybookTask::class, 'gig_playbook_task_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(GigPlaybookTaskComment::class, 'gig_playbook_task_comment_id', 'id');
    }

    public function scopeOrderByPublishDate($query)
    {
        $query->orderBy('publish_date');
    }
}
