# Study App

資格試験学習の進捗管理と模試分析を行う Web アプリ。
試験ごとの学習記録、模試結果、分析グラフを一元管理し、継続状況や学習傾向を可視化できる。

Blade ベースのアプリケーションとして構築しつつ、分析 UI では Vue + Chart.js を部分導入している。

ポートフォリオ作成と学習目的を兼ねて開発したアプリで、まずは Web デモ版を無料公開する前提で作成。
iOS / Android 版の展開と、`Free / Pro` のサブスクリプション化を想定。

## URL

- Web デモ: https://study-app-df4s.onrender.com
- デモ用アカウント
    - email: `test@example.com`
    - password: `password`

## 主な機能

- ユーザー登録 / ログイン / ログアウト
- 試験の作成 / 一覧 / 編集 / 削除
- 学習記録の作成 / 一覧 / 編集 / 削除
- 模試結果の作成 / 一覧 / 編集 / 削除
- 偏差値の任意登録
- 試験ごとの分析ダッシュボード
- プロフィール設定
    - 名前
    - メールアドレス
    - 週間学習目標日数
    - 1日の目標学習時間
    - パスワード変更
    - 退会

## 分析機能

- 月別学習時間
- 直近 7 日の学習時間
- 継続指標
- 最新模試の科目別レーダーチャート
- 模試推移
- 科目別学習時間
- 試験一覧での全試験合計サマリー

## 使用技術

- PHP 8.2+
- Laravel 12
- Laravel Breeze
- Blade
- Vue.js
- Tailwind CSS
- Chart.js
- MySQL
- Vite

## 画面イメージ

- ダッシュボード
- 試験一覧
- 試験詳細
- 模試管理
- 分析ダッシュボード
- プロフィール設定

スクリーンショットは今後追加予定です。

## ドキュメント

要件定義書・設計書は `docs` 配下で管理。

- [要件定義書](docs/01_requirements.md)
- [機能一覧](docs/basic_design/01_function_list.md)
- [画面設計](docs/basic_design/02_screen_design.md)
- [DB設計](docs/basic_design/03_database_design.md)
- [DB詳細設計](docs/basic_design/06_database_design.md)
- [詳細設計](docs/detailed_design/08_internal_design.md)

## フロントアセット

- 開発中は `npm run dev` で Vite 開発サーバーを起動
- `npm run dev` を停止すると開発用アセットは反映されない
- 停止後も見た目を維持したい場合は `npm run build` を実行して `public/build` を生成する

## Render での注意点

- Web デモは Render の free プランで公開している
- 15 分程度アクセスがないとサービスがスリープし、次回アクセス時は起動まで約 1 分かかることがある
- 本番環境のデータベースは Postgres を利用しているため、ローカルの MySQL と日付関数の挙動が異なる点に注意

## 今後の方針

- README / 画面イメージ / ドキュメントを整備してポートフォリオ化
- iOS / Android 版へ展開

## 工夫した点

- Controller / Service / Model の責務分離
- 試験単位での学習記録・模試管理の一貫した導線設計
- Blade ベースを維持しつつ、分析 UI のみ Vue + Chart.js を部分導入
- プロフィール設定と分析指標をつなげた目標管理

## ライセンス

本リポジトリはポートフォリオ用途で公開予定。
必要に応じてライセンスは別途整理するが、現状は特に指定なし。
