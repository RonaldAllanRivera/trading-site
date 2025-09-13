# The Immediate Trade Pro — Laravel 12 + Filament 4

This repository contains a Laravel 12 application with Filament 4 installed for the admin panel, a public-facing landing site, and a simple public user dashboard + authentication (signup/login/logout). The landing pages are implemented as Blade views using modular includes and static assets served from `public/landing-pages/`.

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
  - `resources/views/landing/dashboard.blade.php` → `/dashboard` (auth)
  - `resources/views/landing/privacy.blade.php` → `/privacy`
  - `resources/views/landing/terms.blade.php` → `/terms`
  - `resources/views/landing/cookie.blade.php` → `/cookie`
- Legal content partials
  - `resources/views/landing/pages/privacy-content.blade.php`
  - `resources/views/landing/pages/terms-content.blade.php`
  - `resources/views/landing/pages/cookie-content.blade.php`

Routes are declared in `routes/web.php`.

## Authentication & Dashboard (Public)

- Signup form posts to `POST /leads` and creates both a `Lead` and a `User`, then logs the user in and redirects to `/dashboard`.
- Login form posts to `POST /login`, logout posts to `POST /logout`.
- Authenticated users see a small header banner with “Hello, {name}” and a “Go to Dashboard” button.
- Top and mobile menus are auth-aware (hide Sign Up, switch Login→Logout when authenticated).
- Password helpers on signup:
  - “Generate passwords” button fills a simple password (e.g., `trade123`) and reveals it.
  - Tooltip beside the password explains simple passwords are allowed.

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

If you encounter a collation error on `password_reset_tokens` with older MySQL/MariaDB, set your DB to utf8mb4 (MySQL 5.7+/MariaDB 10.3+) or adjust the migration to limit string length (191).

4. Create an admin user (option A: seed)
```
cp .env.example .env
# Set these in .env before seeding:
# ADMIN_NAME="Admin"
# ADMIN_EMAIL="admin@example.com"
# ADMIN_PASSWORD="changeme123"
php artisan db:seed --class=Database\\Seeders\\AdminSeeder
```

Or create an admin user (option B: wizard)
```
php artisan make:filament-user
```
Follow the prompts. This uses the default `users` table/`web` guard. Then promote to admin (if needed):
```
php artisan tinker
>>> App\Models\User::where('email', 'admin@example.com')->update(['is_admin' => true]);
```

5. Seed demo leads (optional)
```
php artisan db:seed --class=Database\\Seeders\\LeadSeeder
```

6. Run the app
```
php artisan serve
```
Open:

- `http://127.0.0.1:8000/` — Public homepage
- `http://127.0.0.1:8000/login` — Public login page
- `http://127.0.0.1:8000/sign-up` — Public sign-up page
- `http://127.0.0.1:8000/dashboard` — Public dashboard (auth required)
- `http://127.0.0.1:8000/privacy` — Privacy Policy
- `http://127.0.0.1:8000/terms` — Terms and Conditions
- `http://127.0.0.1:8000/cookie` — Cookie Policy
- `http://127.0.0.1:8000/admin` — Filament Admin

## Admin Notes

- Filament uses the default `web` guard and `App\Models\User`.
- Admin access is restricted:
  - `App\Models\User::canAccessPanel()` only allows users with `is_admin = true`.
  - Middleware `App\Http\Middleware\EnsureAdmin` redirects non-admin authenticated users away from `/admin/*` to `/dashboard`.
- Admin login page includes a “Forgot your password?” link that uses the same reset flow as public users.
- Roadmap: migrate to a dedicated Admin guard + model when needed.

## Password Reset & Change Password

- Forgot password (public and admin):
  - GET `/forgot-password` → request reset link
  - POST `/forgot-password` → send email (configure Mail in `.env`)
  - GET `/reset-password/{token}` → reset form
  - POST `/reset-password` → update password
- Change password (authenticated users):
  - GET `/settings/password` and POST `/settings/password`

## Seeding

- Initial admin: `php artisan db:seed --class=Database\\Seeders\\AdminSeeder`
- Demo leads (15 records): `php artisan db:seed --class=Database\\Seeders\\LeadSeeder`
- All seeders: `php artisan db:seed`

## Testing Tutorial (Step-by-step)

1) Public signup → dashboard
   - Visit `/sign-up`, fill fields (simple password allowed or click “Generate passwords”).
   - Submit; you’ll be redirected to `/dashboard` and a `Lead` + `User` will be created.

2) Public login/logout
   - Visit `/login`, enter your credentials.
   - Menus update: hides “Sign Up”, shows a POST “Logout” button, header banner shows “Hello, {name}”.

3) Admin access (allowed only for admins)
   - Create admin via seeder or promote an existing user’s `is_admin` to true.
   - Visit `/admin` and sign in. Non-admins are redirected to `/dashboard`.

4) Leads management (Filament)
   - Visit `/admin/leads` as an admin to see all leads (seeded or collected via signup form).

5) Forgot/reset password
   - Visit `/forgot-password`, request a reset link (configure Mail in `.env`).
   - Use the emailed token to open `/reset-password/{token}` and set a new password.

6) Change password (authenticated)
   - Visit `/settings/password` and submit current + new password.

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

- Introduce a dedicated Admin guard and resources (Leads, Pixels, Cloaking Rules, Traffic Logs, Settings).
- Wire up tracking/consent and language switcher as needed.
- Expand public dashboard features.

## License

MIT
