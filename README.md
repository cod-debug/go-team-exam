# How to run the app on local environment

## Install php/laravel dependencies ignore platform requirements
```bash
composer install --ignore-platform-reqs
```

## Install node/vuejs dependencies force
```bash
npm install --force
```

## copy .env.example file to .env file
```bash
cp .env.example .env
```

### Open and edit .env file, specifically database connection (this may vary, depending on your database local development setup)

## Run database migration
```bash
php artisan migrate
```

## Generate app key
```bash
php artisan key:generate
```

## Compile vuejs
```bash
npm run build
```

## Run the laravel app
```bash
php artisan serve
```