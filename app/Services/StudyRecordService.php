<?php

namespace App\Services;

use App\Models\Exam;
use App\Models\StudyRecord;

class StudyRecordService
{
    /**
     * 一覧取得
     */
    public function list(Exam $exam)
    {
        return $exam->studyRecords()
            ->orderByDesc('study_date')
            ->get();
    }

    /**
     * 作成
     */
    public function create(Exam $exam, array $data)
    {
        return $exam->studyRecords()->create([
            'user_id' => auth()->id(),
            'study_date' => $data['study_date'],
            'subject' => $data['subject'],
            'study_minutes' => $data['study_minutes'],
            'memo' => $data['memo'] ?? null,
        ]);
    }

    /**
     * 更新
     */
    public function update(StudyRecord $record, array $data)
    {
        $record->update([
            'study_date' => $data['study_date'],
            'subject' => $data['subject'],
            'study_minutes' => $data['study_minutes'],
            'memo' => $data['memo'] ?? null,
        ]);

        return $record;
    }

    /**
     * 削除
     */
    public function delete(StudyRecord $record)
    {
        $record->delete();
    }
}
