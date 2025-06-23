#!/bin/bash

until php -r "try { \$pdo = new PDO('mysql:host=$DB_HOST;port=$DB_PORT', '$DB_USERNAME', '$DB_PASSWORD'); exit(0); } catch (Exception \$e) { exit(1); }"; do sleep 3; done

composer install --optimize-autoloader --no-interaction

php artisan key:generate

php artisan optimize

php artisan migrate:fresh --force

php artisan db:seed

php artisan serve --host=0.0.0.0 --port=8000