# The Immediate Trade Pro — Laravel 12 + Filament 4

This repository contains a Laravel 12 application with Filament 4 installed for the admin panel, and the full public-facing landing pages implemented as Blade views using modular includes and static assets served from `public/landing-pages/`.

## Tech Stack

- Laravel 12 (PHP 8.2+)
- Filament 4 (Livewire v3)
- MySQL / MariaDB

## Public Landing Pages

The public site is built from the static assets under `public/landing-pages/` and Blade views under `resources/views/landing/`.

- Layout
  - `resources/views/layouts/landing.blade.php` — skeleton page that includes head, header, sticky CTA, footer, and scripts.
- Includes (ported from `landing-pages/includes/`)
  - `resources/views/landing/includes/head.blade.php`
  - `resources/views/landing/includes/header.blade.php`
  - `resources/views/landing/includes/nav-desktop.blade.php`
  - `resources/views/landing/includes/nav-mobile.blade.php`
  - `resources/views/landing/includes/sticky.blade.php`
  - `resources/views/landing/includes/footer.blade.php`
  - `resources/views/landing/includes/scripts.blade.php`
  - `resources/views/landing/includes/form-signup.blade.php`
  - `resources/views/landing/includes/form-login.blade.php`
  - `resources/views/landing/includes/main.blade.php` (homepage sections)
- Pages
  - `resources/views/landing/home.blade.php` → `/`
  - `resources/views/landing/login.blade.php` → `/login`
  - `resources/views/landing/sign-up.blade.php` → `/sign-up`
  - `resources/views/landing/privacy.blade.php` → `/privacy`
  - `resources/views/landing/terms.blade.php` → `/terms`
  - `resources/views/landing/cookie.blade.php` → `/cookie`
- Legal content partials
  - `resources/views/landing/pages/privacy-content.blade.php`
  - `resources/views/landing/pages/terms-content.blade.php`
  - `resources/views/landing/pages/cookie-content.blade.php`

Routes are declared in `routes/web.php`.

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
Open:

- `http://127.0.0.1:8000/` — Public homepage
- `http://127.0.0.1:8000/login` — Public login page
- `http://127.0.0.1:8000/sign-up` — Public sign-up page
- `http://127.0.0.1:8000/privacy` — Privacy Policy
- `http://127.0.0.1:8000/terms` — Terms and Conditions
- `http://127.0.0.1:8000/cookie` — Cookie Policy
- `http://127.0.0.1:8000/admin` — Filament Admin

## Admin Notes

- Filament currently uses the default `web` guard and `App\Models\User` model.
- Previously generated custom admin resources and tables (Leads, Pixels, Cloaker, etc.) were removed to keep the codebase clean. They can be reintroduced later.
- Roadmap: introduce a dedicated Admin guard with Filament resources for Leads, Pixels, Cloaking Rules, Traffic Logs, and Settings.

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

- Implement admin modules (Leads, Pixels, Cloaker, Traffic Logs, Settings) with Filament resources.
- Wire up tracking/consent and language switcher as needed.
- Implement backend handling/validation for public sign-up/login forms.

## License

MIT
