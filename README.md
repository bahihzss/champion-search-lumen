## Lumen のサンプル

どんな感じになるのか口頭や文面で説明したもわかりづらいと思うので。  
とりあえず、ユーザーを登録と参照できるだけの API で書いてみました。

### 書いてみて感じたメリット

* PHP 8.1 がいい感じ
    * 名前付き引数やコンストラクタプロパティなどモダンな仕様を積極的に取り入れているので、書き口がかなり良くなっている
    * プロパティにも型をつけられるので、割と型安全にできる
* テストの準備がしやすい
    * クラスベースなのでテスト内でグローバルな変数を作りやすい
    * DatabaseMigrations トレイトが便利
    * E2E もメソッドチェーンでさらさら書ける
* バリデーションが楽
    * バリデーションも枯れてるので、痒い所に手が届く印象
* 全部同期関数だから、処理を追いやすい

### 書いてみて感じたデメリット

* DB スキーマの定義〜 ORM は TypeScript + Prisma の方が良かった
    * DB 関連で作るファイルが多い・・・
* Laravel にあるのに Lumen にない機能で戸惑う
    * `key:generate` だけ足しました。笑
* コード補完に関してはやっぱり TypeScript の方がしっかり効く
    * マジックメソッドでの実装が多いので、戻り値の方が曖昧すぎる・・・
    * ide-helper で少しマシになった
* CoC 由来のエラーを見落としがち
    * PHPStorm のリファクタリング機能を使って名前を変更しても、関連する名称が変更されないのでリファクタリングが辛い
* DI コンテナが使いづらい
    * これに関しては Nest.js の方がわかりやすいし、楽に感じる
    * もうちょっと使うと印象変わるかも？

## 開発環境の準備

PHP 8.1 で書いたので、ひと通り Docker で用意しました。

### Docker コンテナを立ち上げ

```bash
docker-compose up -d
docker-compose exec app bash
```

以下はコンテナ内で実行

### インストール

```bash
cp .env.example .env
composer install
php artisan key:generate
```

### データベースのマイグレーション

```bash
php artisan migrate:fresh
```

### テスト実行

```bash
vendor/bin/phpunit
```

## フォルダ構成

一部省略しています

```
app
├── Console
│   ├── Commands
│   │   └── KeyGenerateCommand.php
├── Domain
│   └── User
│       ├── Entities
│       │   └── User.php
│       └── UserRepository.php
├── Http
│   └── Controllers
│       └── User
│           ├── UserFindByIdController.php
│           └── UserRegisterController.php
├── Infrastructure
│   ├── Models
│   │   └── UserModel.php
│   └── Repositories
│       └── UserEloquentRepository.php
└── Providers
    └── UserRepositoryProvider.php
database
├── factories
│   └── Infrastructure
│       └── Models
│           └── UserModelFactory.php
└── migrations
    └── 2021_12_09_102043_create_users_table.php
routes
└── web.php
tests
├── Domain
│   └── Entities
│       └── UserTest.php
├── E2E
│   └── User
│       ├── UserFindByIdControllerTest.php
│       └── UserRegisterControllerTest.php
├── Infrastructure
│   └── Repositories
│       └── UserEloquentRepositoryTest.php
└── TestCase.php
```

基本的に Nest.js で作成したサンプルと同様の構成で、 Lumen の仕様に合わせて適宜変更している感じになっています。

## コーディング規約

### ファイル名

PSR-4 に準拠
`app` `tests` のサブディレクトリは全てパスカルケース

### コード整形

PhpStorm の Laravel プリセットで自動フォーマット  
もし、 PhpStorm を使われていない方がいれば、PSR-2 準拠

### 型づけ

#### 関数・メソッド

基本的に全ての引数に型をつける ライブラリの問題で戻り値を正しく推論できない場合は戻り値の型もつける

#### プロパティ

全てのプロパティに方をつける

#### Eloquent Model

データベースの型と Eloquent Model の型を一致させるためにマイグレーションファイルおよびモデルを作成したら、 `php artisan ide-helper:models` を `yes` で実行する

### 規約の追加・変更

レビューの際に、違和感や統一した方が良さそうな箇所があれば Notion で提案し、決定すればコーディング規約に追加する
