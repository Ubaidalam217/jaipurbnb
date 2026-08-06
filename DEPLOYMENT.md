# Deployment

Setting up JaipurBnB locally, and deploying it to Railway (staging) and
Hostinger (production).

---

## Tech stack

| Layer | Choice |
| --- | --- |
| Framework | Laravel 12 |
| Language | PHP 8.2+ (developed against 8.3) |
| Database | SQLite locally, MySQL (InnoDB) in production |
| Front end | Bootstrap 5, Blade templates |
| Build | Vite 6 + SCSS (`sass`) |
| JS libraries | jQuery, Owl Carousel, AOS, Slick, GSAP, Magnific Popup |
| Icons / fonts | Font Awesome 6, Google Fonts (Poppins) |

Required PHP extensions: `mbstring`, `pdo_mysql` (both declared in
`composer.json`, which is what tells the Railway builder to install
them).

> **Laravel 12 note.** There is no `app/Http/Kernel.php`. Middleware is
> registered in `bootstrap/app.php`, and scheduled tasks live in
> `routes/console.php`. Tutorials referencing `Http/Kernel.php` or
> `Console/Kernel.php` do not apply.

---

## Local setup

```bash
# 1. Clone
git clone <repo-url> jaipurbnb
cd jaipurbnb

# 2. PHP dependencies
composer install

# 3. JS dependencies
npm install

# 4. Environment
cp .env.example .env
php artisan key:generate
```

Then edit `.env`. For local development SQLite is the least friction:

```dotenv
DB_CONNECTION=sqlite
# leave DB_HOST / DB_PORT / DB_DATABASE / DB_USERNAME / DB_PASSWORD commented out
```

```bash
# 5. Create the SQLite file
touch database/database.sqlite        # Windows: type nul > database\database.sqlite

# 6. Schema
php artisan migrate

# 7. Seed (see "Seeding" below for what each seeder does)
php artisan db:seed --class=AdminSeeder
php artisan db:seed --class=SamplePropertySeeder

# 8. Make uploaded photos reachable at /storage/...
php artisan storage:link

# 9. Build front-end assets
npm run build

# 10. Serve
php artisan serve
```

The site is then at <http://127.0.0.1:8000>.

For active front-end work use `npm run dev` instead of `npm run build` to
get hot module replacement.

### Using MySQL locally instead

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jaipurbnb
DB_USERNAME=root
DB_PASSWORD=
```

Create the database first (`CREATE DATABASE jaipurbnb;`), then
`php artisan migrate`. All migrations use only Laravel's schema builder
specifically so they run unchanged on both SQLite and MySQL.

---

## Environment variables

`.env.example` is the reference — it lists every variable with safe
placeholder values. The ones that matter most:

| Variable | Notes |
| --- | --- |
| `APP_KEY` | `php artisan key:generate`. Unique per environment. |
| `APP_ENV` | `local` / `production` |
| `APP_DEBUG` | **`false` in production** |
| `APP_URL` | Must match the real host, or reset-password emails link to the wrong domain |
| `DB_CONNECTION` | `sqlite` locally, `mysql` in production |
| `DB_URL` | Full connection URL. Takes precedence over the discrete `DB_*` vars — this is how Railway is wired |
| `SESSION_DRIVER` | `database` |
| `CACHE_STORE` / `QUEUE_CONNECTION` | `database` |
| `FILESYSTEM_DISK` | `public` |
| `BCRYPT_ROUNDS` | `12` |
| `MAIL_*` | `MAIL_MAILER=log` until real SMTP is supplied |
| `ADMIN_EMAIL` / `ADMIN_PASSWORD` / `ADMIN_NAME` | Consumed by `AdminSeeder` |
| `REVIEW_ADMIN_PASSWORD` | Second review-only admin. Set it, or a default from source is used |

Never commit real values. `.env` is gitignored.

---

## Migrations

```bash
php artisan migrate            # apply pending
php artisan migrate --force    # apply without the production confirmation prompt
php artisan migrate:status     # what has and has not run
php artisan migrate:fresh      # DROP everything and rebuild — destroys data
```

`--force` is required for any non-interactive run (deploys, CI).

---

## Seeding

| Seeder | Creates | Safe to re-run |
| --- | --- | --- |
| `AdminSeeder` | Primary admin from env, plus `reviewadmin@jaipurbnb.com` | Yes — keyed on email |
| `SamplePropertySeeder` | Demo host + 6 demo listings with remote placeholder photos | Yes — keyed on email and `(host_id, title)` |

```bash
php artisan db:seed --class=AdminSeeder --force
php artisan db:seed --class=SamplePropertySeeder --force
```

Both are idempotent, which is why they can sit in the deploy start
command. Note that re-running **rewrites the seeded passwords back to the
environment values** — change the variable, not the password in the UI.

`SamplePropertySeeder` is demo content. Do not run it on a production
database that holds real host listings.

---

## Building assets

```bash
npm run build     # production build into public/build/
npm run dev       # dev server with HMR
```

`public/build/` is gitignored and rebuilt on every deploy. Blade template
changes do **not** go through Vite — only SCSS and JS do.

---

## Railway (current staging)

Staging runs at
`https://web-production-b8517.up.railway.app`, project `serene-analysis`,
services `web` (this app) and `MySQL`.

**Builder: Railpack** (not Nixpacks). Consequences:

- PHP extensions are derived from `composer.json`, which is why
  `ext-pdo_mysql` is declared there — without it the runtime image has no
  MySQL driver and migrations fail with *"could not find driver"*.
- The start command comes from `railpack.json` in the repo root:

  ```json
  {
    "deploy": {
      "startCommand": "php artisan migrate --force && php artisan db:seed --class=AdminSeeder --force && php artisan db:seed --class=SamplePropertySeeder --force && php artisan serve --host=0.0.0.0 --port=$PORT"
    }
  }
  ```

- A **Custom Start Command set in the Railway dashboard overrides this
  file**. If deploy behaviour does not match `railpack.json`, check
  Settings → Deploy first.
- Railpack runs `php artisan config:cache` at **build** time, so service
  variables must exist *before* the build. Adding a variable and merely
  restarting will not pick it up — it needs a rebuild.

**Database.** `DB_URL` is set to `${{MySQL.MYSQL_URL}}`, a Railway
reference that resolves to the internal connection string. Using the
reference rather than a hardcoded URL means it survives a password
rotation.

**HTTPS.** Railway terminates TLS at its edge and forwards plain HTTP.
`bootstrap/app.php` calls `$middleware->trustProxies(at: '*')` so Laravel
honours `X-Forwarded-Proto`; without it `asset()` emits `http://` URLs
that browsers block as mixed content. `AppServiceProvider` additionally
forces the HTTPS scheme in production as a backstop.

**Deploying:** push to `main`. Railway builds from GitHub automatically.

```bash
railway logs -b     # build logs
railway logs -d     # runtime logs
railway status      # service state
```

### Railway limitations to be aware of

- **No volume is mounted on the `web` service**, so uploaded photos are
  lost on every redeploy. Acceptable for a demo; not for production.
  This is one reason the demo listings use remote placeholder images.
- `php artisan serve` is PHP's single-threaded development server. Fine
  for review, not for real traffic.

---

## Hostinger (final production)

1. **Upload the code** via Git or hPanel File Manager. The web root must
   point at `public/`, not the project root.
2. **`composer install --no-dev --optimize-autoloader`**
3. **Create a MySQL database** in hPanel and set `DB_CONNECTION=mysql`
   with the discrete `DB_HOST` / `DB_DATABASE` / `DB_USERNAME` /
   `DB_PASSWORD` values (Hostinger has no `DB_URL`; the config falls back
   to these automatically).
4. **`.env`** — copy `.env.example`, set real values, `APP_ENV=production`,
   `APP_DEBUG=false`, `APP_URL=https://jaipurbnb.com`, then
   `php artisan key:generate`.
5. **`php artisan migrate --force`**
6. **Seed the admin** — run `AdminSeeder` *before* `config:cache`, or run
   `php artisan config:clear` first. Once config is cached the seeder
   cannot read `env()` and will refuse to create the account.
7. **`php artisan storage:link`.** If Hostinger blocks or strips
   symlinks, fall back to writing uploads directly into
   `public/uploads/properties/` and update the disk config plus stored
   `image_url` paths. Decide this during deployment, not before.
8. **`npm run build` locally and upload `public/build/`**, or run the
   build on the server if Node is available.
9. **Cron** — one entry drives the scheduler:

   ```
   * * * * * cd /home/USER/jaipurbnb && php artisan schedule:run >> /dev/null 2>&1
   ```

   If per-minute cron is unavailable, point a daily 00:00 cron straight
   at `php artisan properties:hide-expired`, which is self-contained.
10. **Optimise:**

    ```bash
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    ```

    Re-run these after any `.env` change, and remember step 6.

### Production checklist

- [ ] `APP_DEBUG=false`
- [ ] `APP_URL` matches the live domain
- [ ] Fresh `APP_KEY` (not copied from staging)
- [ ] Real `ADMIN_PASSWORD`; `REVIEW_ADMIN_PASSWORD` set or the review account deleted
- [ ] Real SMTP in `MAIL_*`
- [ ] `SamplePropertySeeder` **removed** from the start command
- [ ] `storage/` and `bootstrap/cache/` writable
- [ ] HTTPS certificate active
- [ ] Scheduler cron installed
