## How to Install Application

1.  composer install or composer update

2.  npm install

3.  cp .env.example .env

4.  change DB_DATABASE=agrishop in .env

5.  php artisan key:generate

6.  php artisan migrate

7.  php artisan db:seed PermissionsDemoSeeder

8.  create database name agrishop

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
