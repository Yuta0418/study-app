# mock_exams テーブル定義

## 概要

試験ごとの模試結果を管理する。

---

## カラム定義

| カラム名        | データ型     | NULL | KEY | デフォルト        | 説明                 |
| --------------- | ------------ | ---- | --- | ----------------- | -------------------- |
| id              | BIGINT       | ×    | PK  | AUTO_INCREMENT    | 模試ID               |
| exam_id         | BIGINT       | ×    | FK  |                   | 試験ID               |
| name            | VARCHAR(255) | ×    |     |                   | 模試名               |
| taken_at        | DATE         | ×    |     |                   | 受験日               |
| total_score     | INT          | ×    |     |                   | 総合点               |
| deviation_value | DECIMAL(5,2) | ⚪︎   |     |                   | 偏差値               |
| created_at      | TIMESTAMP    | ×    |     | CURRENT_TIMESTAMP | 作成日時             |
| updated_at      | TIMESTAMP    | ×    |     | CURRENT_TIMESTAMP | 更新日時             |
| deleted_at      | TIMESTAMP    | ○    |     | NULL              | 削除日時（論理削除） |

---

## インデックス

- PRIMARY KEY (id)
- FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE
- INDEX (exam_id, taken_at)

---

## リレーション

- N模試 : 1試験（exam_id）
- 1模試 : N科目得点

```sql
CREATE TABLE mock_exams (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    exam_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    taken_at DATE NOT NULL,
    total_score INT NOT NULL,
    deviation_value DECIMAL(5,2) NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL
        DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT fk_mock_exams_exam
        FOREIGN KEY (exam_id)
        REFERENCES exams(id)
        ON DELETE CASCADE,
    INDEX idx_exam_taken_at (exam_id, taken_at)
);
```
