# Install php/laravel dependencies ignore platform requirements
`composer install --ignore-platform-reqs`

# Install node/vuejs dependencies force
npm install --force

# copy .env.example file to .env file
cp .env.example .env

# Open and edit .env file, specifically database connection (this may vary, depending on your database local development setup)

# Run database migration
php artisan migrate

# Generate app key
php artisan key:generate

# Compile vuejs
npm run build

# Run the laravel app
php artisan serve