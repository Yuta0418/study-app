# users テーブル定義

## 概要

ユーザー情報を管理するテーブル。

---

## カラム定義

| カラム名   | データ型     | NULL | KEY         | デフォルト        | 説明                 |
| ---------- | ------------ | ---- | ----------- | ----------------- | -------------------- |
| id         | BIGINT       | ×    | PRIMARY KEY | AUTO_INCREMENT    | ユーザーID           |
| name       | VARCHAR(100) | ×    |             |                   | 名前                 |
| email      | VARCHAR(255) | ×    | UNIQUE      |                   | メールアドレス       |
| password   | VARCHAR(255) | ×    |             |                   | ハッシュ化パスワード |
| created_at | TIMESTAMP    | ×    |             | CURRENT_TIMESTAMP | 作成日時             |
| updated_at | TIMESTAMP    | ×    |             | CURRENT_TIMESTAMP | 更新日時             |
| deleted_at | TIMESTAMP    | ⚪︎   |             |                   | 削除日時（論理削除） |

---

## インデックス

- PRIMARY KEY (id)
- UNIQUE KEY (email)

---

## リレーション

- 1ユーザー : N試験（exams.user_id）

```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL
        DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    CONSTRAINT uq_users_email UNIQUE (email)
);
```
