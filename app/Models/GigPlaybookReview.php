<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GigPlaybookReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'gig_playbook_id',
        'reviewer_id',
        'reviewee_id',
        'review',
        'review_date',
        'status',
    ];

    public function gigPlaybook()
    {
        return $this->belongsTo(GigPlaybook::class, 'gig_playbook_id', 'id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id', 'id');
    }

    public function reviewee()
    {
        return $this->belongsTo(User::class, 'reviewee_id', 'id');
    }
}
