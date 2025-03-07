## How to Install Application

1.  composer install or composer update

2.  npm install

3.  cp .env.example .env

4.  change DB_DATABASE=safetagum in .env

5.  php artisan key:generate

6.  php artisan migrate

7.  php artisan db:seed PermissionsDemoSeeder

8.  create database name safetagum

9.  php artisan passport:install

10. Register to have Access

11. Default Account

    demo users
    name = Example User
    email = test@example.com

        name = Example Admin User
        email = admin@example.com

        name = Example Super-Admin User
        email = superadmin@example.com

    Default Password = password

Optional
php artisan storage:link for image storage to public

## Ploi Deployment script
```
cd /home/ploi/bangcs.usecaptura.pro
git pull origin master
composer install --no-interaction --prefer-dist --optimize-autoloader
echo "" | sudo -S service php8.2-fpm reload

echo "🚀 Application deployed!"

php artisan route:cache
php artisan view:clear
php artisan config:clear
php artisan migrate --force

npm install
npm run production
```
