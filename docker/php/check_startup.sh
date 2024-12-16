#!bin/bash

cd /var/www/html

composer update

cp .env.example .env

sed -i -e 's/DB_HOST=127.0.0.1/DB_HOST=db/g' .env
sed -i -e 's/DB_PASSWORD=/DB_PASSWORD=root/g' .env

php artisan key:generate
php artisan storage:link

chown www-data storage/ -R

php artisan cache:clear

npm install
npm run build

cd /usr/local/etc/php

cp php.ini-development php.ini
sed -i 's|^session.save_path = .*$|session.save_path = "/var/www/html/storage/framework/sessions"|' /usr/local/etc/php/php.ini

php atrisan migrate