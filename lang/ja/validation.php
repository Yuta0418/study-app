<?php

return [
    'array' => ':attributeは配列で入力してください。',
    'confirmed' => ':attributeと確認用の入力が一致しません。',
    'current_password' => '現在のパスワードが正しくありません。',
    'date' => ':attributeは正しい日付を入力してください。',
    'email' => ':attributeは正しいメールアドレス形式で入力してください。',
    'gte' => [
        'array' => ':attributeは:value件以上にしてください。',
        'file' => ':attributeは:valueKB以上にしてください。',
        'numeric' => ':attributeは:value以上を入力してください。',
        'string' => ':attributeは:value文字以上で入力してください。',
    ],
    'integer' => ':attributeは整数で入力してください。',
    'max' => [
        'numeric' => ':attributeは:max以下を入力してください。',
        'string' => ':attributeは:max文字以内で入力してください。',
        'array' => ':attributeは:max件以下にしてください。',
    ],
    'min' => [
        'numeric' => ':attributeは:min以上を入力してください。',
        'string' => ':attributeは:min文字以上で入力してください。',
        'array' => ':attributeは:min件以上必要です。',
    ],
    'numeric' => ':attributeは数値で入力してください。',
    'required' => ':attributeは必須です。',
    'string' => ':attributeは文字列で入力してください。',
    'unique' => 'この:attributeはすでに使用されています。',

    'custom' => [
        'target_score' => [
            'gte' => '目標得点は合格基準点以上を入力してください。',
        ],
    ],

    'attributes' => [
        'name' => '名前',
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'password_confirmation' => 'パスワード確認',
        'current_password' => '現在のパスワード',
        'exam_date' => '試験日',
        'passing_score' => '合格基準点',
        'target_score' => '目標得点',
        'study_date' => '学習日',
        'subject' => '科目',
        'study_minutes' => '学習時間',
        'memo' => 'メモ',
        'taken_at' => '受験日',
        'deviation_value' => '偏差値',
        'subjects' => '科目一覧',
        'subjects.*' => '科目',
        'scores' => '得点一覧',
        'scores.*' => '得点',
        'weekly_goal_days' => '週間学習目標日数',
        'daily_goal_minutes' => '1日の目標学習時間',
    ],
];
