# Laravel Navigation Guide
### CMSC 121: Internet Technologies - Assignment 7

## 1. Getting Started: The Development Server
To view your application in the browser, you must run the built-in development server. Ensure your terminal is at the project root (`/freedom-board`).

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan serve
```

---

## 2. Frontend Assets (Tailwind & Breeze)
Since Assignment 7 uses Laravel Breeze, you need to compile your CSS and JavaScript files.

* **Install Dependencies:** `npm install`
* **Hot Reload (Development):** `npm run dev`
* **Build for Production:** `npm run build`

---

## 3. Database Management (Migrations)
Instead of manual SQL imports, Laravel uses Migrations to manage your `posts` and `users` tables.

* **Run all pending migrations:** `php artisan migrate`
* **Rollback last migration:** `php artisan migrate:rollback`
* **Wipe and re-run migrations:** `php artisan migrate:fresh`

---

## 4. Directory Cheat Sheet
* `app/Http/Controllers/`: Where your `PostController` logic lives.
* `app/Models/`: Where the `Post` and `User` data structures (Eloquent) are defined.
* `resources/views/`: Your `.blade.php` files (UI templates).
* `routes/web.php`: The map that connects URLs to Controller methods.
* `database/migrations/`: PHP files that define your database schema.
* `.env`: Your configuration file (Database credentials, App Key).

---

## 5. Security & Maintenance
* **CSRF Protection:** Laravel automatically blocks POST requests without a `@csrf` token.
* **Middleware:** The `auth` middleware protects the Freedom Board from unauthenticated access.
* **Clear Caches:** If changes aren't appearing or you see routing errors, run:
    ```bash
    php artisan optimize:clear
    ```

## 6. Scaffolding Commands
To generate a new class or file:
```bash
# Generate a Controller
php artisan make:controller ControllerName

# Generate a Model and a Migration at the same time
php artisan make:model ModelName -m
```
