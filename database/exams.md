# exams テーブル定義

## 概要

ユーザーごとの試験を管理する。

---

## カラム定義

| カラム名   | データ型     | NULL | KEY     | デフォルト        | 説明                 |
| ---------- | ------------ | ---- | ------- | ----------------- | -------------------- |
| id         | BIGINT       | ×    | PRIMARY | AUTO_INCREMENT    | 試験ID               |
| user_id    | BIGINT       | ×    | FK      |                   | ユーザーID           |
| name       | VARCHAR(255) | ×    |         |                   | 試験名               |
| created_at | TIMESTAMP    | ×    |         | CURRENT_TIMESTAMP | 作成日時             |
| updated_at | TIMESTAMP    | ×    |         | CURRENT_TIMESTAMP | 更新日時             |
| deleted_at | TIMESTAMP    | ○    |         | NULL              | 削除日時（論理削除） |

---

## インデックス

- PRIMARY KEY (id)
- FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
- INDEX (user_id)

---

## リレーション

- N試験 : 1ユーザー
- 1試験 : N学習記録
- 1試験 : N模試

```sql
CREATE TABLE exams (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL
        DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT fk_exams_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE,
    INDEX idx_user_id (user_id)
);
```
