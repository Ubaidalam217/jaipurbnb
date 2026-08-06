# Security

How JaipurBnB protects accounts, uploads and data. Everything below
describes code that exists in this repository today. Where a control is
planned but not yet built, it is listed under
[Known gaps](#known-gaps-as-of-milestone-12) rather than implied.

---

## Password storage

Passwords are hashed with **bcrypt**, never stored or logged in plain text.

Hashing is applied by Laravel's `hashed` cast on the `User` model, so any
code path that assigns a password gets the same treatment — there is no
route that writes a raw password to the database.

```php
// app/Models/User.php
protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
```

Cost factor is **12 rounds**, set via `BCRYPT_ROUNDS=12` in the
environment (see `.env.example`, and the Railway service variables).

Password rules on both signup and reset: minimum 8 characters, confirmed
by a second field (`RegisterRequest`, `ResetPasswordController`).

---

## Authentication and authorization

Authentication is hand-rolled — no Breeze/Jetstream/Fortify — because the
front end is Bootstrap 5 and the starter kits ship Tailwind views.

### Roles

`users.role` is a string column with two allowed values, `host` and
`admin`, defined as constants on the model (`User::ROLE_HOST`,
`User::ROLE_ADMIN`) and enforced at the model and Form Request layers.

### Route protection

Two middleware aliases are registered in `bootstrap/app.php`:

```php
$middleware->alias([
    'host'  => \App\Http\Middleware\EnsureUserIsHost::class,
    'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
]);
```

Applied as route groups in `routes/web.php`:

| Area | Middleware | Prefix |
| --- | --- | --- |
| Host dashboard, listings, calendar | `auth`, `host` | `/host` |
| Admin panel, moderation | `auth`, `admin` | `/admin` |
| Login, register, password reset | `guest` | — |

### Ownership checks

Being a host is not enough to touch *another* host's listing. Both
`Host\PropertyController` and `Host\AvailabilityController` funnel every
record through an `ownedOrFail()` check that **returns 404, not 403**:

```php
abort_unless($property->host_id === auth()->id(), 404);
```

403 would confirm that a given listing ID exists. 404 does not.

---

## File upload validation

Only property photos can be uploaded, only by an authenticated host, and
only through `PropertyStoreRequest` / `PropertyUpdateRequest`:

| Control | Rule |
| --- | --- |
| File type | `mimes:jpg,jpeg,png,webp` |
| Real image check | `image` (verifies actual image data, not just extension) |
| Size limit | `max:5120` (5 MB per file) |
| Count limit | `max:15` per listing |
| At least one | `min:1` on create; edit blocks removing the last photo |

Files are written through Laravel's storage layer, which assigns a
random 40-character hashed filename — the host's original filename is
never used as a path:

```php
// app/Http/Controllers/Host/PropertyController.php
$path = $file->store('properties/'.$property->id, 'public');
```

Uploads land under `storage/app/public/properties/{property_id}/` and are
served through the `public` disk. A host-supplied name therefore cannot
influence where a file is written or what it is called.

---

## Sessions and CSRF

- **Driver:** `database` (`SESSION_DRIVER=database`), so sessions are not
  readable from the filesystem and survive process restarts.
- **Session fixation:** the session ID is regenerated immediately after
  authentication succeeds, on both login (`LoginController`) and
  registration (`RegisterController`).
- **Logout:** `Auth::logout()`, then `session()->invalidate()` and
  `session()->regenerateToken()` — the old session and its CSRF token are
  both discarded.
- **CSRF:** Laravel's `VerifyCsrfToken` runs on the whole `web` group.
  Every state-changing form carries `@csrf`, and the calendar's
  block/unblock `fetch()` sends the token header.
- **Cookies:** `SESSION_ENCRYPT` is available; `SESSION_LIFETIME=120`
  minutes.

---

## Rate limiting

Public endpoints that accept credentials are throttled to **6 requests
per minute** per IP:

| Route | Limit |
| --- | --- |
| `POST /login` | `throttle:6,1` |
| `POST /register` | `throttle:6,1` |
| `POST /forgot-password` | `throttle:6,1` |
| `POST /reset-password` | `throttle:6,1` |

This blunts password brute-forcing and scripted bulk signups.

---

## Account enumeration

`POST /forgot-password` returns the same message whether or not the
address is registered ("If that email is registered, a password reset
link is on its way"). Confirming which addresses have accounts would turn
a public form into a user-list oracle.

---

## Mass assignment protection

`users.role` is deliberately **excluded** from `User::$fillable`, so a
crafted `role=admin` field in a registration POST cannot escalate
privileges. Admin accounts are created only by `AdminSeeder`, which sets
the role explicitly in code.

The same pattern applies to listings: `host_id`, `listing_status`,
`is_verified` and `is_visible` are never taken from request input — the
controller sets them.

---

## SQL injection protection

All database access goes through Eloquent and the query builder, which
use PDO prepared statements with bound parameters. There is no raw SQL in
the application or in any migration — migrations use only Laravel's
schema builder, which is also what keeps them portable between SQLite
(local) and MySQL (production).

---

## Secrets and environment

- `.env` is **gitignored** (`.gitignore` line 3) and has never been
  committed.
- Admin credentials come from environment variables
  (`ADMIN_EMAIL`, `ADMIN_PASSWORD`, `ADMIN_NAME`), never from source.
- `AdminSeeder` **refuses to create an account** if `ADMIN_PASSWORD` is
  unset or if config caching has made `env()` unreadable — it prints an
  error rather than silently creating an admin with a known placeholder
  password.
- `APP_KEY` is generated per environment and is not shared between
  staging and production.
- `.env.example` documents every variable with no real values.

---

## Known gaps as of Milestone 1+2

Listed so they are decisions rather than surprises:

1. **`REVIEW_ADMIN_PASSWORD` has a fallback in source.** If the variable
   is unset, `AdminSeeder` creates `reviewadmin@jaipurbnb.com` with a
   default password that is readable in this repository. Set the variable
   on any internet-reachable deployment, and delete the account once the
   review window closes.
2. **No email verification.** A new host can list immediately; the admin
   approval step is what gates public visibility.
3. **No two-factor authentication.**
4. **Password reset emails are not delivered yet.** `MAIL_MAILER=log`
   writes the reset link to `storage/logs/laravel.log`. Real SMTP
   credentials come from the client before launch.
5. **Payments are not integrated.** Razorpay is a Milestone 3 item; no
   payment code or keys exist in the repository yet.
6. **Uploads are not virus-scanned** beyond MIME and image validation.
7. **Rate limiting is per-IP**, so it does not stop a distributed attack.

---

## Reporting a vulnerability

Email **hello@jaipurbnb.com** with steps to reproduce. Please do not open
a public GitHub issue for a security report.
