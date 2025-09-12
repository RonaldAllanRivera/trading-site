# The Immediate Trade Pro — Laravel 12 + Filament 4

This repository contains a Laravel 12 application with Filament 4 installed for the admin panel. The public landing pages will be added later; for now, only the admin is in scope.

## Tech Stack

- Laravel 12 (PHP 8.2+)
- Filament 4 (Livewire v3)
- MySQL / MariaDB

## Local Development

1. Install dependencies
```
composer install
```

2. Environment
```
cp .env.example .env
php artisan key:generate
```
Update DB credentials in `.env`.

3. Migrate database
```
php artisan migrate
```

4. Create an admin user (without seeders)
```
php artisan make:filament-user
```
Follow the prompts. This uses the default `users` table/`web` guard.

5. Run the app
```
php artisan serve
```
Open `http://127.0.0.1:8000/admin` to access Filament.

## Admin Notes

- Filament currently uses the default `web` guard and `App\Models\User` model.
- Previously generated custom admin resources and tables (Leads, Pixels, Cloaker, etc.) were removed to keep the codebase clean. They can be reintroduced later.

## Deployment (Namecheap/cPanel quick notes)

1. Point the domain's document root to `public/`.
2. Upload code or connect via Git/SSH.
3. Run in SSH:
```
composer install --no-dev --optimize-autoloader
php artisan key:generate --force
php artisan migrate --force
php artisan optimize
```
4. Ensure correct file permissions for `storage/` and `bootstrap/cache/`.

## Next Steps

- Implement admin modules (Leads, Pixels, Cloaker) with Filament resources.
- Add landing pages as Blade views and wire tracking/consent.

## License

MIT
