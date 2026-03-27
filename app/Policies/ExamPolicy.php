<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Exam;

class ExamPolicy
{
    /**
     * 一覧表示
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * 作成
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * 表示
     */
    public function view(User $user, Exam $exam): bool
    {
        return $user->id === $exam->user_id;
    }

    /**
     * 更新
     */
    public function update(User $user, Exam $exam): bool
    {
        return $user->id === $exam->user_id;
    }

    /**
     * 削除
     */
    public function delete(User $user, Exam $exam): bool
    {
        return $user->id === $exam->user_id;
    }
}
