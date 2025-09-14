# The Immediate Trade Pro — Laravel 12 + Filament 4

This repository contains a Laravel 12 application with Filament 4 admin, a polished public landing site, and a complete public authentication flow (signup/login/logout, password reset, change password) with a simple dashboard. It includes lead capture, admin CRUD for users and leads, CSV export, seeders, and a testing guide. Landing pages are implemented as Blade views using modular includes and static assets served from `public/landing-pages/`.

## Table of Contents

- Overview (this section)
- [Tech Stack](#tech-stack)
- [Quick Start (Local)](#quick-start-local)
- [Features](#features)
- [Public Landing Pages](#public-landing-pages)
- [Authentication & Dashboard (Public)](#authentication--dashboard-public)
- [Local Development](#local-development)
- [Admin Notes](#admin-notes)
- [Testing Tutorial (Step-by-step)](#testing-tutorial-step-by-step)
- [How to Test Cloaker](#how-to-test-cloaker)
- [Deployment (SiteGround SSH + GitHub)](#deployment-siteground-ssh--github)
- [Troubleshooting](#troubleshooting)
- [License](#license)

## Tech Stack

- Laravel 12 (PHP 8.2+)
- Filament 4 (Livewire v3)
- MySQL / MariaDB

## Quick Start (Local)

1) Install dependencies
```bash
composer install
```
2) Configure environment
```bash
cp .env.example .env
php artisan key:generate
```
3) Migrate and seed (optional)
```bash
php artisan migrate --seed
```
4) Run the app
```bash
php artisan serve
```

### Key URLs
- `http://127.0.0.1:8000/` — Home
- `http://127.0.0.1:8000/sign-up` — Sign up
- `http://127.0.0.1:8000/login` — Login
- `http://127.0.0.1:8000/admin` — Filament Admin

## Features

- Public Landing Experience
  - Modular Blade includes with production static assets.
  - Auth-aware header/menus: hide Sign Up and switch Login→Logout when authenticated.
  - "Hello, {name}" banner with a “Go to Dashboard” button for signed-in users.

- Lead Capture & Public Auth
  - Signup posts to `POST /leads`, creates both a `Lead` and a `User`, then logs in and redirects to `/dashboard`.
  - Frictionless password UX: simple passwords allowed, a one-click generator, show/hide toggle, and a tooltip.
  - Public login/logout with `/login` and `POST /logout`.
  - Password reset (forgot/reset) and change password pages.

- Dashboard
  - Minimal dashboard at `/dashboard` under the landing layout.

- Admin (Filament 4)
  - Leads: list with search, status badge/filter, and CSV export.
  - Users: list/create/edit with `is_admin` toggle and optional password update.
  - Pixels: list/create/edit pixel snippets with provider, location, status, and notes.
  - Cloaker: create rules (whitelist/blacklist) with match types (ip/country/ua/referrer/param), metrics, admin tester with presets and run-on-route buttons.
  - Access control: only users with `is_admin = true` can access `/admin`; non-admins are redirected to `/dashboard`.
  - Admin login includes a “Forgot your password?” link.

- Data & Seeders
  - `AdminSeeder` reads `ADMIN_NAME|EMAIL|PASSWORD` from `.env` and promotes the user to admin.
  - `LeadSeeder` seeds 15 realistic leads.
  - `LeadFactory` auto-creates a matching `User` (password: `password`) for each seeded lead.

- Developer Experience
  - Clear route map, environment/bootstrap steps, and testing tutorial.
  - CSV export endpoint streams in chunks for memory efficiency.

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

7) Export leads as CSV (admin)
   - Visit `/admin/leads` as an admin.
   - Click the `Export CSV` header action; a streamed CSV download will open in a new tab.

8) Cloaker quick test (admin)
   - Visit Filament → Marketing → `Cloaker` and click `Test Cloaker`.
   - Use `Use Rule` to select a rule or a shortcut preset, then Submit. See detailed steps in the next section.

## How to Test Cloaker

The cloaker is active on `/` and `/sign-up` via `App\Http\Middleware\CloakerMiddleware`.

- Admin-side tester (recommended)
  - In Filament: Marketing → Cloaker → click `Test Cloaker` in the header.
  - Use Rule: select any active rule (e.g., "Blacklist Google Reviewers"). The form auto-fills a matching test. You can still tweak values.
  - Shortcut Preset: `Normal User`, `Google Reviewers`, `Facebook Reviewers`, or `Custom`.
  - Fields: choose IP, Country (ISO 2), User Agent, Referrer; add Query Params as Key/Value. Custom fields appear when needed.
  - Submit: see the decision (SAFE/OFFER/allow) and the matched rule name.
  - Run on actual route: the notification includes buttons to open `/` and `/sign-up` in new tabs. These links include testing overrides: `__ua`, `__ref`, `__country` so the middleware can simulate those values.
  - Use `Reset Counters` to zero `hits_safe` / `hits_offer` across all rules.

- Postman testing (also available)
  - Import the ready-made collection: `docs/postman/CloakerTests.postman_collection.json` and set `baseUrl` if needed.
  - Requests included (redirects disabled per request):
    - Home / Sign-up — Google Reviewers (UA)
    - Home / Sign-up — Facebook Reviewers (UA + Referrer)
    - Home / Sign-up — Country header example (SG via CF-IPCountry)
    - Home / Sign-up — Param Match (utm_source)
  - Tips:
    - Turn OFF "Automatically follow redirects" globally to always see `302 Location` (optional; per-request is already disabled).
    - You can add `__country=XX` as a query param if you’re not behind Cloudflare.
  - Results:
    - With redirects OFF: expect `302` with `Location: /safe` or `Location: /`.
    - With redirects ON: Postman follows to the final page content (Safe or Offer).

- Counters and visibility
  - Each redirect increments `hits_safe` or `hits_offer` on the matched rule.
  - Open any rule in Filament to see the counters; use `Reset Counters` to clear.

- Quick toggle
  - You can disable the cloaker globally by adding `CLOAKING_ENABLED=false` in `.env` and (optionally) referencing it in `config/app.php`:
    ```php
    // config/app.php
    'cloaking_enabled' => env('CLOAKING_ENABLED', true),
    ```

## Deployment (SiteGround SSH + GitHub)

Use SiteGround SSH to deploy directly from GitHub. SiteGround SSH guide: https://world.siteground.com/tutorials/ssh/putty/

1) Prepare SSH and repo access
- Generate or use an SSH key in SiteGround → Site Tools → Devs → SSH Keys Manager.
- Add the public key to GitHub (either as a repository Deploy key or on your GitHub account) so you can use the SSH clone URL.

2) Choose your layout
- Option A — Recommended (secure): keep the repo outside `public_html` and point your domain to the app's `public/`
  - Pros: app files are outside web root; least risk of exposing `.env`.
  - How:
    - Clone to `~/apps/trading-site` (or similar)
    - Point the domain's document root to `~/apps/trading-site/public` (Site Tools → Domain → Document Root), or symlink `public_html` to that `public/`.
- Option B — Quick (works but less secure): clone directly into `public_html` and rewrite everything to `/public`
  - Pros: simplest when you cannot change document root.
  - Cons: the full Laravel repo lives in web root; rely on .htaccess to route only through `public/` and block sensitive files.

3) Clone from GitHub (SSH)
```bash
# SSH into SiteGround (see tutorial link above)
ssh USER@SERVER

# Option A: outside public_html (recommended)
mkdir -p ~/apps && cd ~/apps
git clone --depth 1 git@github.com:RonaldAllanRivera/trading-site.git
cd trading-site

# Option B: directly into public_html (quick)
cd ~/www/ARTWORKDOMAIN.COM/public_html
git clone --depth 1 git@github.com:RonaldAllanRivera/trading-site.git .
```

Quick start for artworkwebsite.com (Option B)
```bash
# 1) SSH into the server
ssh USER@SERVER

# 2) Backup current site (optional)
cd ~/www/artworkwebsite.com/
mv public_html public_html.backup_$(date +%s)
mkdir -p public_html && cd public_html

# 3) Clone your GitHub repo directly into public_html
git clone --depth 1 git@github.com:RonaldAllanRivera/trading-site.git .

# 4) Environment
cp .env.example .env
sed -i 's|APP_URL=.*|APP_URL=https://artworkwebsite.com|' .env
nano .env   # set DB_*, MAIL_*, etc.

# 5) Install & optimize
composer install --no-dev --optimize-autoloader
php artisan key:generate --force
php artisan storage:link
php artisan migrate --force --seed   # remove --seed if not desired
php artisan optimize

# 6) Ensure root .htaccess exists to forward to /public and block sensitive files
test -f .htaccess && echo "Root .htaccess found" || echo "See README for a sample .htaccess to create here"
```

4) Configure environment
```bash
cp .env.example .env
# Edit .env and set APP_URL, DB_* credentials, MAIL_*, etc.
nano .env
```

5) Install dependencies and build cache
```bash
composer install --no-dev --optimize-autoloader
php artisan key:generate --force
php artisan storage:link
php artisan migrate --force --seed   # remove --seed if not desired
php artisan optimize
```

6) Web server docroot
- Option A (recommended): set document root to the app `public/`.
- Option B (if cloning into `public_html`): ensure an `.htaccess` in `public_html` rewrites to `/public` and blocks sensitive files.

Example `.htaccess` for Option B (Apache 2.4):
```apache
<IfModule mod_rewrite.c>
  RewriteEngine On
  # send everything to /public
  RewriteCond %{REQUEST_URI} !^/public/
  RewriteRule ^(.*)$ public/$1 [L,QSA]
</IfModule>

# extra hardening (deny direct access to sensitive files)
<FilesMatch "^(\.env|artisan|composer\.(json|lock)|package\.json|webpack\.mix\.js|vite\.config\.js)$">
  Require all denied
</FilesMatch>
```

7) File permissions (shared hosting defaults)
```bash
find storage -type d -exec chmod 775 {} \;
find storage -type f -exec chmod 664 {} \;
chmod -R 775 bootstrap/cache
```

8) Updating to a new version
```bash
# Option A
cd ~/apps/trading-site
# Option B
# cd ~/www/ARTWORKDOMAIN.COM/public_html

git pull --rebase
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize
```

Alternative: convert an existing `public_html` into a Git working copy
```bash
# WARNING: this will overwrite local changes. Backup first.
cd ~/www/ARTWORKDOMAIN.COM/public_html

# Backup
tar -czf ../public_html_backup_$(date +%Y%m%d_%H%M%S).tar.gz .

# If a .git already exists and points elsewhere, remove it
rm -rf .git

# Initialize and attach your GitHub repo
git init
git remote add origin git@github.com:RonaldAllanRivera/trading-site.git
git fetch --depth 1 origin main
git reset --hard origin/main

# Install and optimize
composer install --no-dev --optimize-autoloader
php artisan key:generate --force
php artisan storage:link
php artisan migrate --force --seed   # remove --seed if not desired
php artisan optimize
```


## License

MIT
