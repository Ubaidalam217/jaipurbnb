# Database schema

Every table, the migration that creates it, and how the tables relate.

**Portability.** All migrations use only Laravel's schema builder — no raw
SQL — so the same files run unchanged on SQLite (local development) and
MySQL InnoDB (production). Two rules follow from that and are worth
knowing before you add a migration:

- **No `->after()`.** It is a MySQL-only column-ordering modifier and is
  silently ignored on SQLite.
- **No native `ENUM` columns.** SQLite has no ENUM type. Fixed value sets
  are plain `string` columns, with the allowed values enforced at the
  model layer (class constants) and in Form Request validation, *not* by
  a database constraint.

---

## Application tables

### `users`

Hosts and admins share one table, separated by `role`.

Created by `0001_01_01_000000_create_users_table.php`, extended by
`2026_07_30_190001_add_role_and_phone_to_users_table.php`.

| Column | Type | Notes |
| --- | --- | --- |
| `id` | bigint PK | |
| `name` | string | |
| `email` | string | **unique** |
| `email_verified_at` | timestamp, nullable | Not currently used — no verification flow |
| `password` | string | bcrypt, via the model's `hashed` cast |
| `remember_token` | string, nullable | |
| `role` | string(20), default `host` | `host` \| `admin`. **Not mass-assignable** |
| `phone_number` | string(20), nullable | **unique** — drives WhatsApp/Call buttons |
| `created_at` / `updated_at` | timestamps | |

> `phone_number` being UNIQUE has bitten seeding twice. Any seeder that
> assigns a placeholder number must check whether it is already taken —
> two accounts cannot share one.

### `properties`

The core listing table.

Created by `2026_07_30_190002_create_properties_table.php`, extended by
`2026_07_30_200001_add_rejection_reason_to_properties_table.php` and
`2026_08_06_170658_add_guests_bedrooms_to_properties_table.php`.

| Column | Type | Notes |
| --- | --- | --- |
| `id` | bigint PK | |
| `host_id` | FK → `users.id` | cascade on delete |
| `title` | string(150) | |
| `description` | text | |
| `neighborhood` | string(100) | One of `Property::NEIGHBORHOODS` (22 values) |
| `stay_type` | string(50) | One of `Property::STAY_TYPES` (5 values) |
| `approx_price` | integer | Rupees per night, indicative not binding |
| `max_guests` | integer, default 2 | Browse "Guests" filter |
| `bedrooms` | integer, default 1 | Browse "Bedrooms" filter |
| `bathrooms` | integer, default 1 | Display only |
| `is_verified` | boolean, default false | |
| `is_visible` | boolean, default false | Live-on-site flag |
| `listing_status` | string(20), default `pending` | `pending` \| `approved` \| `rejected` |
| `rejection_reason` | string, nullable | Set when an admin rejects |
| `subscription_expiry` | date, nullable | |
| `verification_doc_url` | string(255), nullable | |
| `ical_feed_url` | string(255), nullable | Airbnb `.ics` URL — **stored but not yet consumed** |
| `created_at` / `updated_at` | timestamps | |

Indexes: `(neighborhood, stay_type)`, `is_visible`, `subscription_expiry`,
`(max_guests, bedrooms)`.

> **`listing_status` and `is_visible` are two independent axes and must
> not be merged.** `listing_status` is admin moderation state.
> `is_visible` is the live-on-site flag, flipped to `false` by the daily
> expiry sweep when `subscription_expiry` passes. An expired listing stays
> `approved` but becomes invisible. Listing data is never deleted.
>
> The public visibility gate is therefore **both**:
> `listing_status = 'approved' AND is_visible = true`.

### `property_images`

`2026_07_30_190003_create_property_images_table.php`

| Column | Type | Notes |
| --- | --- | --- |
| `id` | bigint PK | |
| `property_id` | FK → `properties.id` | cascade on delete, indexed |
| `image_url` | string(255) | Disk-relative path, e.g. `properties/17/abc.jpg` — **or** a fully qualified remote URL for seeded demo rows |
| `is_cover` | boolean, default false | One cover per listing |
| `created_at` / `updated_at` | timestamps | |

Max 15 photos per listing, enforced in the Form Request, not the schema.

> Render photos through `PropertyImage::$display_url`, never
> `Storage::url($image->image_url)` directly. The accessor passes absolute
> URLs through untouched and only routes disk-relative paths through
> `Storage::url()`; calling `Storage::url()` on a remote URL produces
> `/storage/https://...`.

### `property_availability`

`2026_07_30_190004_create_property_availability_table.php`

| Column | Type | Notes |
| --- | --- | --- |
| `id` | bigint PK | |
| `property_id` | FK → `properties.id` | cascade on delete |
| `calendar_date` | date | |
| `status` | string(20) | `available` \| `blocked` \| `booked` |
| `source` | string(20), default `manual` | `manual` \| `airbnb_sync` |
| `created_at` / `updated_at` | timestamps | |

Unique on `(property_id, calendar_date)` — one row per property per day.

A date with **no row** is treated as available; rows are only written
when something changes. `source` decides ownership: hosts may only edit
`manual` rows, so the future iCal sync can replace its own `airbnb_sync`
rows without fighting the host.

### `lead_analytics`

`2026_07_30_190005_create_lead_analytics_table.php`

| Column | Type | Notes |
| --- | --- | --- |
| `id` | bigint PK | |
| `property_id` | FK → `properties.id` | cascade on delete |
| `lead_type` | string(30) | `whatsapp_click` \| `call_click` \| `profile_view` |
| `clicked_at` | timestamp, default now | |

Indexed on `(property_id, lead_type)`. No `updated_at` — rows are
append-only events. Written from the browser via `navigator.sendBeacon`,
which survives the page unloading on a WhatsApp/tel navigation.

### `transactions`

`2026_07_30_190006_create_transactions_table.php`

Schema is in place; **no payment code writes to it yet** (Razorpay is
Milestone 3).

| Column | Type | Notes |
| --- | --- | --- |
| `id` | bigint PK | |
| `host_id` | FK → `users.id` | **restrict** on delete — payment records outlive accounts |
| `property_id` | FK → `properties.id`, nullable | null on delete |
| `gateway_payment_id` | string(100) | **unique** — Razorpay's id, also the idempotency guard |
| `pack_duration_days` | integer | 30 / 90 / 365 |
| `amount_paid` | decimal(10,2) | |
| `payment_status` | string(20) | `pending` \| `success` \| `failed` \| `refunded` |
| `refund_reason` | string(255), nullable | |
| `paid_at` | timestamp, nullable | |
| `created_at` / `updated_at` | timestamps | |

---

## Framework tables

Created by Laravel's default migrations; no application code touches them
directly.

| Table | Migration | Purpose |
| --- | --- | --- |
| `password_reset_tokens` | `0001_01_01_000000` | Password reset. Email PK, single-use token, 60-minute expiry |
| `sessions` | `0001_01_01_000000` | `SESSION_DRIVER=database` |
| `cache`, `cache_locks` | `0001_01_01_000001` | `CACHE_STORE=database` |
| `jobs`, `job_batches`, `failed_jobs` | `0001_01_01_000002` | `QUEUE_CONNECTION=database` |
| `migrations` | framework | Migration ledger |

---

## Relationships

```
users (host)
  │
  ├──< properties            host_id      cascade delete
  │      │
  │      ├──< property_images        property_id   cascade delete
  │      ├──< property_availability  property_id   cascade delete
  │      ├──< lead_analytics         property_id   cascade delete
  │      └──< transactions           property_id   null on delete
  │
  └──< transactions          host_id      RESTRICT delete
```

Eloquent equivalents:

| Model | Relationship |
| --- | --- |
| `User` | `hasMany(Property, 'host_id')`, `hasMany(Transaction, 'host_id')` |
| `Property` | `belongsTo(User, 'host_id')`, `hasMany(PropertyImage)`, `hasOne(PropertyImage)` filtered `is_cover`, `hasMany(PropertyAvailability)`, `hasMany(LeadAnalytic)`, `hasMany(Transaction)` |
| `PropertyImage` | `belongsTo(Property)` |

Deleting a host cascades away their listings, photos, availability and
lead rows — but is **blocked** if they hold transactions, so payment
history cannot be silently destroyed.

---

## Running migrations

```bash
php artisan migrate              # apply pending
php artisan migrate --force      # non-interactive (deploys, CI)
php artisan migrate:status       # what has and has not run
php artisan migrate:rollback     # undo the last batch
```

### From scratch

```bash
php artisan migrate:fresh                          # DROPS every table, rebuilds
php artisan db:seed --class=AdminSeeder --force
php artisan db:seed --class=SamplePropertySeeder --force   # demo data — never on production
```

`migrate:fresh` destroys all data. On production use plain `migrate`.

Local SQLite lives at `database/database.sqlite`; deleting that file and
re-running `migrate` is the fastest full reset.

---

## Seeders

| Seeder | Creates | Idempotent on |
| --- | --- | --- |
| `AdminSeeder` | Admin from `ADMIN_*` env, plus `reviewadmin@jaipurbnb.com` | email |
| `SamplePropertySeeder` | Demo host + 6 listings + 1 cover photo each | email, `(host_id, title)`, `(property_id, is_cover)` |

Both are safe to re-run and sit in the Railway deploy start command. Note
that re-running **rewrites seeded passwords back to the environment
values** — change the variable, not the password in the UI.

---

## Test database

The suite uses `RefreshDatabase` against SQLite, migrating fresh per test
class. Factories: `UserFactory`, `PropertyFactory` (with `live()` and
`expired()` states for the two visibility axes). 98 tests currently pass.
