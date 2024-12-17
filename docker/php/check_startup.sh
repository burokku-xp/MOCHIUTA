#!/bin/bash

# /var/www/html ディレクトリに移動できるか確認
cd /var/www/html || { echo "Failed to navigate to /var/www/html"; exit 1; }

# composerの依存関係を更新
composer update

# .env.example から .env をコピー
cp .env.example .env

# DB接続設定を変更
sed -i -e 's/DB_HOST=127.0.0.1/DB_HOST=db/g' .env
sed -i -e 's/DB_PASSWORD=/DB_PASSWORD=root/g' .env

# アプリケーションキーを生成し、ストレージリンクを作成
php artisan key:generate
php artisan storage:link

# storage ディレクトリの権限を設定
chown www-data storage/ -R

# キャッシュをクリア
php artisan cache:clear

# npmの依存関係をインストールし、フロントエンドをビルド
npm install
npm run build

# /usr/local/etc/php に移動できるか確認
cd /usr/local/etc/php || { echo "Failed to navigate to /usr/local/etc/php"; exit 1; }

# php.iniが存在しなければ、php.ini-development をコピー
if [ ! -f php.ini ]; then
    cp php.ini-development php.ini
fi

# セッション保存パスを設定
sed -i 's|^session.save_path = .*$|session.save_path = "/var/www/html/storage/framework/sessions"|' php.ini

# マイグレーションを実行
php artisan migrate