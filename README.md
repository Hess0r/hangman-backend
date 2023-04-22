# Hangman backend

This is the repository for the backend of the Hangman Game application.

## Installation

To install dependencies run:

```bash
composer install
```

Create a `.env` file, and configure database connecton:

```bash
cp .env.example .env
```

Create application key:

```bash
php artisan key:generate
```

Database migratons can be run with the following command:

```bash
php artisan migrate --seed
```

This will also run the `database/seeders/DatabaseSeeder.php` seeder, which loads the initial words, and sets up a test user, with email address `test@example.com`, and password `password`.

## Running the application

The development server can be started with:

```bash
php artisan serve
```

The required php version is `^8.1`;

> NOTE: Laravel Sanctum is used for authentication, so if the frontend is running on a different address then the usual (localhost:3000, localhost:5173, etc.), extend the stateful domains with the required value.
