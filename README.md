# CA Apps

## Tools

-   PHP v8.2
-   Node v21.5

## Installation

```shell
git clone https://github.com/Fajar3108/cash-advance
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan storage:link
```

Note:

Setup your database configuration in .env file

```shell
php artisan migrate --seed
```

## Run

Frontend Resource

```shell
# development
npm run dev
# production
npm run build
```

Laravel

```shell
php artisan serve
```
