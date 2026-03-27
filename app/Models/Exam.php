<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'exam_date',
        'passing_score',
        'target_score',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function studyRecords()
    {
        return $this->hasMany(StudyRecord::class);
    }

    public function mockExams()
    {
        return $this->hasMany(MockExam::class);
    }
}
