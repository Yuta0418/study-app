<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MockSubjectScore extends Model
{
    protected $fillable = [
        'mock_exam_id',
        'subject',
        'score'
    ];

    public function mockExam()
    {
        return $this->belongsTo(MockExam::class);
    }
}
