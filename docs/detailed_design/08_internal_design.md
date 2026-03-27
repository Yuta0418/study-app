# 08. 詳細設計

# 1. アーキテクチャ方針

### 1.1 採用アーキテクチャ

Controller + Service 分離型アーキテクチャを採用する。

```
Controller → Service → Model
```

### 1.2 責務分離

Controller
• リクエスト受付
• 認可実行（Policy）
• Service呼び出し
• レスポンス返却

Service
• ビジネスロジック
• 分析処理
• トランザクション管理
• 業務例外送出

Model
• データ構造定義
• リレーション定義のみ

⸻

### 1.3 禁止事項

• ModelからServiceを呼ばない
• ServiceからControllerを呼ばない
• Controllerにビジネスロジックを書かない
• Modelに集計ロジックを書かない

⸻

# 2. ディレクトリ構成

```
app
├── Http
│   ├── Controllers
│   │   ├── ExamController.php
│   │   ├── ExamAnalysisController.php
│   │   ├── StudyRecordController.php
│   │   ├── MockExamController.php
│   │   └── ProfileController.php
│   └── Requests
│       ├── StoreExamRequest.php
│       ├── UpdateExamRequest.php
│       ├── StoreStudyRecordRequest.php
│       ├── UpdateStudyRecordRequest.php
│       ├── StoreMockExamRequest.php
│       ├── UpdateMockExamRequest.php
│       └── ProfileUpdateRequest.php
│
├── Models
│   ├── Exam.php
│   ├── StudyRecord.php
│   ├── MockExam.php
│   ├── MockSubjectScore.php
│   └── User.php
│
├── Policies
│   └── ExamPolicy.php
│
└── Services
    ├── ExamService.php
    ├── ExamAnalysisService.php
    ├── StudyRecordService.php
    └── MockExamService.php
```

# 3. コントローラ設計

### 3.1 ExamController

責務

試験ドメインのCRUD操作

想定メソッド
• index()
• list()
• create()
• store()
• show()
• edit()
• update()
• destroy()

設計ルール
• 認可はPolicyを使用
• バリデーションはFormRequest使用
• ビジネスロジックは記述しない

⸻

### 3.2 ExamAnalysisController

責務

分析画面表示用データの取得とビュー返却

想定メソッド
• index()

⸻

### 3.3 StudyRecordController

責務

学習記録のCRUD操作

想定メソッド
• index()
• create()
• store()
• edit()
• update()
• destroy()

⸻

### 3.4 MockExamController

責務

模試情報と科目別得点のCRUD操作

想定メソッド
• index()
• create()
• store()
• edit()
• update()
• destroy()

⸻

### 3.5 ProfileController

責務

プロフィール情報の表示・更新、退会処理

想定メソッド
• edit()
• update()
• destroy()

⸻

# 4. サービス設計

### 4.1 Service構成

```
app/Services/
├── ExamService.php
├── ExamAnalysisService.php
├── StudyRecordService.php
└── MockExamService.php
```

### 4.2 ExamService

責務

試験データのCRUD管理

想定メソッド
• list(int $userId)
• overallStats(int $userId)
• create(int $userId, array $data)
• update(Exam $exam, array $data)
• delete(Exam $exam)

設計方針
• 単純CRUDのみ
• 試験横断サマリーは含む
• 必要に応じてトランザクション使用

⸻

### 4.3 StudyRecordService

責務

学習記録データのCRUD管理

想定メソッド
• list(Exam $exam)
• create(Exam $exam, array $data)
• update(StudyRecord $studyRecord, array $data)
• delete(StudyRecord $studyRecord)

⸻

### 4.4 MockExamService

責務

模試データと科目別得点のCRUD管理

想定メソッド
• list(Exam $exam)
• create(Exam $exam, array $data)
• update(MockExam $mockExam, array $data)
• delete(MockExam $mockExam)

⸻

### 4.5 ExamAnalysisService

責務

試験データの分析・集計

想定メソッド
• summary(Exam $exam)
• weekly(Exam $exam)
• monthly(Exam $exam)
• calendar(Exam $exam)
• continuity(Exam $exam)
• radar(Exam $exam)
• subjectBreakdown(Exam $exam)
• mockTrend(Exam $exam)

設計方針
• CRUDは行わない
• Blade + Chart.js用整形データを返す
• Service間依存を持たない

⸻

# 5. モデル設計

### 5.1 Examモデル

主なカラム
• id
• user_id
• name
• exam_date
• passing_score
• target_score
• created_at
• updated_at
• deleted_at

実装方針
• fillableを明示
• castsを定義
• ビジネスロジックは記述しない

⸻

### 5.2 StudyRecordモデル

主なカラム
• id
• user_id
• exam_id
• study_date
• subject
• study_minutes
• memo
• deleted_at

⸻

### 5.3 MockExamモデル

主なカラム
• id
• exam_id
• name
• taken_at
• total_score
• deviation_value
• deleted_at

⸻

### 5.4 MockSubjectScoreモデル

主なカラム
• id
• mock_exam_id
• subject
• score

⸻

### 5.5 Userモデル

主なカラム
• id
• name
• email
• password
• weekly_goal_days
• daily_goal_minutes

⸻

# 6. リレーション設計

### 6.1 User - Exam

```
User 1 : N Exam
```

```php
public function exams()
{
    return $this->hasMany(Exam::class);
}
```

### 6.2 Exam - StudyRecord

```
Exam 1 : N StudyRecord
```

```php
public function studyRecords()
{
    return $this->hasMany(StudyRecord::class);
}
```

### 6.3 Exam - MockExam

```
Exam 1 : N MockExam
```

```php
public function mockExams()
{
    return $this->hasMany(MockExam::class);
}
```

### 6.4 MockExam - MockSubjectScore

```
MockExam 1 : N MockSubjectScore
```

```php
public function subjectScores()
{
    return $this->hasMany(MockSubjectScore::class);
}
```

設計ルール
• N+1回避のためService層でwith()使用
• リレーション先にロジックを書かない

⸻

# 7. 認可設計（Policy）

### 7.1 方針

• すべてPolicyで管理
• Controllerでauthorize()使用
• Serviceでは認可を行わない

⸻

### 7.2 ExamPolicy

認可条件：
• 操作対象のexam.user_idとログインユーザーIDが一致すること

対象アクション：
• viewAny
• create
• view
• update
• delete

⸻

# 8. バリデーション設計

### 8.1 方針

• FormRequestを使用
• Controller内でvalidateしない
• Serviceでバリデーションしない

⸻

### 8.2 StoreExamRequest

ルール例
• name: required / string / max:255
• exam_date: required / date
• passing_score: nullable / integer / min:0
• target_score: nullable / integer / min:0 / gte:passing_score

⸻

### 8.3 UpdateExamRequest

• Storeと同等のルールを適用

⸻

### 8.4 StoreStudyRecordRequest / UpdateStudyRecordRequest

ルール例
• study_date: required / date
• subject: required / string / max:100
• study_minutes: required / integer / min:1
• memo: nullable / string / max:1000

⸻

### 8.5 StoreMockExamRequest / UpdateMockExamRequest

ルール例
• name: required / string / max:255
• taken_at: required / date
• deviation_value: nullable / numeric / min:0 / max:100
• subjects: required / array / min:1
• subjects.*: required / string / max:100
• scores: required / array / min:1
• scores.*: required / integer / min:0 / max:100

⸻

# 9. トランザクション設計

方針
• Service層で実施
• 単一テーブルCRUDでは使用しない
• 複数テーブル更新時のみ使用

⸻

使用例
• MockExam作成時にMockSubjectScoreを同時登録する場合
• ログテーブル同時登録時

⸻

# 10. 例外処理設計

### 10.1 方針

• 業務例外はServiceでthrow
• Controllerでtry-catchしない
• Handlerで統一処理

⸻

### 10.2 業務例外例

• ExamLimitExceededException
• InvalidScoreException

⸻

### 10.3 処理方針

Web
• エラーメッセージをセッションへ格納

API
• JSON形式でエラー返却

⸻

## 総括

本詳細設計では、
• 責務分離の徹底
• CRUDと分析の分離
• Policyによる認可管理
• FormRequestによる入力検証
• Service中心設計
• トランザクションと例外の統一管理を採用し、拡張性・保守性・実務適合性を確保する。
