# study_records テーブル定義

## 概要

試験単位の学習記録を管理する。

---

## カラム定義

| カラム名      | データ型     | NULL | KEY | デフォルト        | 説明                 |
| ------------- | ------------ | ---- | --- | ----------------- | -------------------- |
| id            | BIGINT       | ×    | PK  | AUTO_INCREMENT    | 学習記録ID           |
| user_id       | BIGINT       | ×    | FK  |                   | ユーザーID           |
| exam_id       | BIGINT       | ×    | FK  |                   | 試験ID               |
| study_date    | DATE         | ×    |     |                   | 学習日               |
| subject       | VARCHAR(100) | ×    |     |                   | 科目                 |
| study_minutes | INT          | ×    |     |                   | 学習時間（分）       |
| memo          | TEXT         | ⚪︎   |     |                   | メモ                 |
| created_at    | TIMESTAMP    | ×    |     | CURRENT_TIMESTAMP | 作成日時             |
| updated_at    | TIMESTAMP    | ×    |     | CURRENT_TIMESTAMP | 更新日時             |
| deleted_at    | TIMESTAMP    | ⚪︎   |     |                   | 削除日時（論理削除） |

---

## インデックス

- PRIMARY KEY (id)
- FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
- FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE
- INDEX (exam_id, study_date)
- INDEX (user_id)

```sql
CREATE TABLE study_records (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    exam_id BIGINT NOT NULL,
    study_date DATE NOT NULL,
    subject VARCHAR(100) NOT NULL,
    study_minutes INT NOT NULL,
    memo TEXT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL
        DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    CONSTRAINT fk_study_records_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_study_records_exam
        FOREIGN KEY (exam_id)
        REFERENCES exams(id)
        ON DELETE CASCADE,
    INDEX idx_exam_date (exam_id, study_date),
    INDEX idx_user (user_id)
);
```
