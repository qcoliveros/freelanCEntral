<?php

namespace App\Models\Parameter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoftSkill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function scopeFilterByName($query, $filter)
    {
        $query->when($filter ?? null, function ($query, $search) {
            $query->where('name', 'LIKE', '%'.$search.'%');
        });
    }
}
