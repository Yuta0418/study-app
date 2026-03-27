# 05. 外部インターフェース設計（API設計）

---

# 1. 概要

本システムは基本的にLaravelのBladeによるサーバーサイドレンダリングで構築する。

ただし、分析画面ではVue.js + Chart.jsを用いた動的描画を行うため、
学習時間・模試データ取得用のJSON APIを提供する。

---

# 2. API設計方針

| 項目       | 内容                      |
| ---------- | ------------------------- |
| 通信方式   | HTTPS                     |
| データ形式 | JSON                      |
| 認証方式   | Laravelセッション認証     |
| API用途    | 分析画面用データ取得      |
| 設計思想   | リソース指向 + 集計汎用化 |

---

# 3. 共通仕様

## 3.1 ベースURL

```
/api
```

---

## 3.2 レスポンス形式

### 成功時

```json
{
    "status": "success",
    "data": {}
}
```

### 失敗時

```json
{
    "status": "error",
    "message": "エラーメッセージ"
}
```

---

## 3.3 HTTPステータスコード

| ステータス | 内容             |
| ---------- | ---------------- |
| 200        | 正常             |
| 400        | 不正なリクエスト |
| 401        | 認証エラー       |
| 500        | サーバーエラー   |

---

# 4. API一覧

---

# 4.1 学習時間集計取得API（汎用）

## ■ 概要

指定単位（日・週・月・年）で学習時間を集計して取得する。

将来的な拡張（weekly / daily / yearly）を考慮した汎用設計とする。

---

## ■ エンドポイント

```
GET /api/study/aggregate
```

---

## ■ リクエストパラメータ

| パラメータ | 型     | 必須 | 説明                              |
| ---------- | ------ | ---- | --------------------------------- |
| type       | string | ○    | daily / weekly / monthly / yearly |
| year       | int    | △    | 年単位集計時に指定                |
| month      | int    | △    | 日別集計時に指定                  |

### リクエスト例（月別）

```
/api/study/aggregate?type=monthly&year=2025
```

### リクエスト例（週別）

```
/api/study/aggregate?type=weekly&year=2025
```

---

## ■ レスポンス例

### 月別

```json
{
    "status": "success",
    "type": "monthly",
    "data": [
        { "period": 1, "total_hours": 45 },
        { "period": 2, "total_hours": 38 },
        { "period": 3, "total_hours": 52 }
    ]
}
```

### 週別

```json
{
    "status": "success",
    "type": "weekly",
    "data": [
        { "period": 1, "total_hours": 12 },
        { "period": 2, "total_hours": 18 },
        { "period": 3, "total_hours": 15 }
    ]
}
```

---

# 4.2 科目別学習時間取得API

## ■ エンドポイント

```
GET /api/study/subjects
```

## ■ リクエストパラメータ

| パラメータ | 型   | 必須 | 説明   |
| ---------- | ---- | ---- | ------ |
| start_date | date | ○    | 開始日 |
| end_date   | date | ○    | 終了日 |

## ■ レスポンス例

```json
{
    "status": "success",
    "data": [
        { "subject": "英語", "total_hours": 120 },
        { "subject": "数学", "total_hours": 95 },
        { "subject": "国語", "total_hours": 60 }
    ]
}
```

---

# 4.3 模試得点推移取得API

## ■ エンドポイント

```
GET /api/mock/score-trend
```

## ■ リクエストパラメータ

| パラメータ | 型     | 必須 | 説明   |
| ---------- | ------ | ---- | ------ |
| subject    | string | ○    | 科目名 |

## ■ レスポンス例

```json
{
    "status": "success",
    "data": [
        { "exam_date": "2025-01-10", "score": 65 },
        { "exam_date": "2025-03-15", "score": 72 },
        { "exam_date": "2025-05-20", "score": 78 }
    ]
}
```

---

# 5. セキュリティ設計

| 項目         | 対応                         |
| ------------ | ---------------------------- |
| 認証         | ログインユーザーのみ利用可能 |
| 認可         | ユーザーIDでデータ制御       |
| CSRF対策     | Laravel標準機能              |
| 不正アクセス | Middlewareで制御             |

---

# 6. 将来的な拡張想定

- 学習予測API
- 偏差値自動計算API
- CSVエクスポートAPI
- AI学習アドバイスAPI

---
