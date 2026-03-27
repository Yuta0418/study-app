<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudyRecord extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'exam_id',
        'study_date',
        'subject',
        'study_minutes',
        'memo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
