<?php

namespace App\Models;

use App\Models\Parameter\Language;
use App\Models\Parameter\LanguageProficiency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLanguage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'language_id',
        'speaking_proficiency_id',
        'writing_proficiency_id',
        'reading_proficiency_id',
    ];

    public function language()
    {
        return $this->hasOne(Language::class, 'id', 'language_id');
    }

    public function speakingProficiency()
    {
        return $this->hasOne(LanguageProficiency::class, 'id', 'speaking_proficiency_id');
    }

    public function writingProficiency()
    {
        return $this->hasOne(LanguageProficiency::class, 'id', 'writing_proficiency_id');
    }

    public function readingProficiency()
    {
        return $this->hasOne(LanguageProficiency::class, 'id', 'reading_proficiency_id');
    }
}
