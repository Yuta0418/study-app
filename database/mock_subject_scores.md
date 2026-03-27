# mock_subject_scores テーブル定義

## 概要

模試ごとの科目別得点を管理する。

---

## カラム定義

| カラム名     | データ型     | NULL | KEY | デフォルト        | 説明                 |
| ------------ | ------------ | ---- | --- | ----------------- | -------------------- |
| id           | BIGINT       | ×    | PK  | AUTO_INCREMENT    | 科目得点ID           |
| mock_exam_id | BIGINT       | ×    | FK  |                   | 模試ID               |
| subject      | VARCHAR(100) | ×    |     |                   | 科目名               |
| score        | INT          | ×    |     |                   | 得点                 |
| created_at   | TIMESTAMP    | ×    |     | CURRENT_TIMESTAMP | 作成日時             |
| updated_at   | TIMESTAMP    | ×    |     | CURRENT_TIMESTAMP | 更新日時             |
| deleted_at   | TIMESTAMP    | ○    |     | NULL              | 削除日時（論理削除） |

---

## インデックス

- PRIMARY KEY (id)
- FOREIGN KEY (mock_exam_id) REFERENCES mock_exams(id) ON DELETE CASCADE
- INDEX (mock_exam_id)

---

## リレーション

- N科目得点 : 1模試（mock_exam_id）

```sql
CREATE TABLE mock_subject_scores (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    mock_exam_id BIGINT NOT NULL,
    subject VARCHAR(100) NOT NULL,
    score INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL
        DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT fk_mock_subject_scores_mock_exam
        FOREIGN KEY (mock_exam_id)
        REFERENCES mock_exams(id)
        ON DELETE CASCADE,
    INDEX idx_mock_exam_id (mock_exam_id)
);
```
