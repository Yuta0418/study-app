<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MockExam extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'exam_id',
        'name',
        'taken_at',
        'total_score',
        'deviation_value'
    ];

    protected $casts = [
        'taken_at' => 'date',
        'deviation_value' => 'decimal:2',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function subjectScores()
    {
        return $this->hasMany(MockSubjectScore::class);
    }
}
