<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyRecord extends Model
{
    protected $fillable = [
        'user_id',
        'subject',
        'study_minutes',
        'study_date',
        'memo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
