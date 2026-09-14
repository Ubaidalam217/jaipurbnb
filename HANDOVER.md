# Handover

**Last updated: 14 September 2026** — status: **build complete, live on
Hostinger at https://jaipurbnb.com**

How JaipurBnB transfers into the client's ownership: code, database,
uploaded photos, hosting, credentials and domain.

Railway was **staging only**. Production is a fresh deployment on the
client's Hostinger account — nothing was "moved" from Railway except the
code, which lives in Git.

---

## Recent Updates — September 2026

Commit [`44e21da`](https://github.com/Ubaidalam217/jaipurbnb/commit/44e21da)
added five client-requested features on top of the four core milestones,
deployed to Hostinger production on 14 September 2026:

- **Guest breakdown** — hosts now set adults / children / infants
  separately instead of one guest count. `properties.max_guests` is a
  **derived** column (`max_adults + max_children`; infants are excluded)
  computed server-side on every save, never trusted from client input.
  The browse "Guests" filter ceiling moved from 8 to 16.
- **Date-based availability filter** — `/browse` accepts `check_in` /
  `check_out` and excludes any listing with a `blocked` or `booked`
  `property_availability` row inside that stay range.
- **Amenities system** — a 25-item picklist (`amenities` +
  `property_amenities` tables, seeded by `AmenitySeeder`) across three
  categories (basics, popular, features; `location` reserved and
  currently empty). Host form has a full multi-select; the browse filter
  requires **every** ticked amenity (AND semantics), and the property
  detail page lists them.
- **Pet-friendly** — a toggle on the host form, a filter checkbox on
  `/browse`, and a badge on both the browse card and the listing page.
- **Google Maps location** — hosts enter latitude/longitude as plain
  text fields (no JS map picker); the listing page embeds a
  `maps.google.com` iframe when both are set.
- **Full address fields** — `full_address` / `city` / `state` /
  `pincode` on every property, and matching optional `host_address` /
  `host_city` / `host_state` / `host_pincode` fields at host
  registration. All new address fields are nullable — nothing here makes
  registration or listing creation stricter than before.

**Verification performed on production (14 September 2026):** all seven
areas above were exercised end-to-end via a throwaway test host +
listing (created and fully deleted afterward — no production data was
touched), confirming: the derived guest count, the 16-guest ceiling, the
date-range exclusion (including that the checkout night itself is not
checked), amenity AND-filtering, the pet-friendly badge/filter, the maps
embed rendering with the correct coordinates, and the address panel. A
real `/register` submission with host address fields was also posted and
verified in the database, then removed. `storage/logs/laravel.log`
carried no new exceptions from this testing. See `TEST_REPORT.md` for
the full pass/fail detail.

**Server cleanup performed the same day:** two pre-cutover leftovers
were removed from the Hostinger account — `~/wp-backup-20260910/` (the
old WordPress DB dump + files tarball taken before the domain was
repointed to Laravel) and `~/domains/jaipurbnb.com/public_html_old/`
(the previous WordPress document root, including a stale `staging`
subfolder). `public_html` was confirmed to still resolve correctly as a
symlink to `laravel_app/public` afterward. `route:cache` was
deliberately **not** run — the homepage is a closure route, and caching
routes on this deployment turns `/` into a 405. **`DEPLOYMENT.md`'s
optimize-for-production step still lists `route:cache` as of this
writing — do not run it on this deployment; that step is stale and
needs correcting.**

---

## 1. Code

The repository is the source of truth. Two options:

**Option A — transfer the repository (recommended).** The current owner
uses GitHub → Settings → *Transfer ownership* to move the repo into the
client's account or organisation. Full history moves with it, the client
becomes owner, and existing clones keep working via the redirect.

**Option B — client forks or is added as owner.** Faster, but leaves the
repo under the original account. Adequate only if the client is happy for
the developer to remain the owner of record.

Either way, **the client should hold admin rights on the repository
before final payment.**

What is *not* in the repository, by design:

- `.env` (gitignored — real secrets never committed)
- `vendor/` and `node_modules/` (installed by Composer/npm)
- `public/build/` (produced by `npm run build`)
- `storage/app/public/` uploads
- `database/database.sqlite` (local dev only)

---

## 2. Database

Production data is MySQL. To move a populated database:

```bash
# Export from the source
mysqldump -u USER -p --single-transaction --routines DBNAME > jaipurbnb.sql

# Import on the client's Hostinger MySQL
mysql -u CLIENT_USER -p CLIENT_DBNAME < jaipurbnb.sql
```

Hostinger's hPanel also exposes phpMyAdmin, which handles both export and
import through the browser if the dump is under the upload limit.

**In practice a dump may not be wanted.** The Railway database holds only
demo content — six seeded listings owned by a fake host, plus test
accounts. For a clean launch it is usually better to start empty:

```bash
php artisan migrate --force
php artisan db:seed --class=AdminSeeder --force   # admin only, no demo data
```

Real host listings are then created through the site.

Decide this explicitly with the client. See `DATABASE.md` for the schema.

---

## 3. Deployment

Full steps are in `DEPLOYMENT.md` → *Hostinger (final production)*. The
shape of it:

1. Code onto Hostinger, web root pointed at `public/`
2. `composer install --no-dev --optimize-autoloader`
3. MySQL database created in hPanel, credentials into `.env`
4. `php artisan key:generate` (a **fresh** key — do not reuse staging's)
5. `php artisan migrate --force`
6. `AdminSeeder` run **before** `config:cache`
7. `php artisan storage:link`
8. `public/build/` uploaded or built on the server
9. Scheduler cron installed
10. `config:cache`, `route:cache`, `view:cache`

Once Hostinger is serving jaipurbnb.com, **retire the Railway project**
so it stops accruing usage and so no stale copy of the site remains
publicly reachable.

---

## 4. Uploaded photos

Property photos live in `storage/app/public/properties/{property_id}/`
and are served through the `public` disk symlink.

**There is nothing to migrate from Railway.** The Railway `web` service
has no volume mounted, so uploaded files do not survive a redeploy — the
demo listings deliberately use remote placeholder images for this reason.
Real photos begin accumulating once hosts upload on Hostinger.

If photos ever do need moving between servers, copy
`storage/app/public/properties/` across and re-run
`php artisan storage:link` on the destination. The `property_images.image_url`
column stores disk-relative paths, so the rows stay valid as long as the
directory structure is preserved.

**One Hostinger caveat:** shared hosting sometimes blocks or strips
symlinks. If `public/storage` does not resolve after `storage:link`,
switch to writing uploads directly into `public/uploads/properties/` and
update the disk config plus any stored `image_url` paths. Decide during
deployment.

---

## 5. Environment and credentials

The client creates their own `.env` on Hostinger from `.env.example`.
Nothing is copied from staging except structure.

| Variable | Who provides | Notes |
| --- | --- | --- |
| `APP_KEY` | Generated on the server | `php artisan key:generate`. Never reuse staging's. |
| `APP_URL` | Client | `https://jaipurbnb.com`. Wrong value = broken password-reset links. |
| `DB_*` | Client | From Hostinger hPanel |
| `MAIL_*` | Client | Their SMTP host, port, username, password |
| `ADMIN_EMAIL` / `ADMIN_PASSWORD` / `ADMIN_NAME` | Client | Consumed by `AdminSeeder` |
| `REVIEW_ADMIN_PASSWORD` | Client | Or delete the review admin entirely |
| `RAZORPAY_*` | Client | Milestone 3; production keys, not test keys |

**Live production logins as at 10 September 2026:**

| What | Value |
| --- | --- |
| Admin panel login | `jaipurbnb@jaipurbnb.com` |
| Admin password | Held in the client's password manager — shared out-of-band, deliberately **not** recorded in this repository |
| Platform contact inbox | `jaipurbnb@jaipurbnb.com` (`CONTACT_EMAIL` in `.env`) |
| Outbound mail | `noreply@jaipurbnb.com` via `smtp.hostinger.com:587` (TLS) |

This repository is **public on GitHub**. No password, API key or SSH
credential belongs in any tracked file — `.env` is gitignored for exactly
this reason. Anything pasted into a commit must be treated as burned and
rotated immediately.

**Credential hygiene at handover:**

- Client sets a **new** `ADMIN_PASSWORD` that the developer has never seen
- Delete `reviewadmin@jaipurbnb.com` once review is finished
- Delete the demo host `demohost@jaipurbnb.com` and its six listings
- Rotate any password shared over chat or email during development
- Developer's access to hPanel, the repo and Railway is revoked when the
  support period ends

---

## 6. Domain

`jaipurbnb.com` points at Hostinger:

1. Client provides registrar access (or updates records themselves)
2. Point nameservers at Hostinger, or set an A record to the Hostinger IP
3. Add the domain in hPanel and attach it to the JaipurBnB directory
4. Issue the free SSL certificate via hPanel
5. Confirm `https://jaipurbnb.com` loads and `http://` redirects to it
6. Set `APP_URL=https://jaipurbnb.com` and re-run `php artisan config:cache`

Allow up to 48 hours for DNS propagation, though it is usually far
quicker.

---

## 7. What the client needs to provide

All Milestone 4 blockers have been supplied and applied:

| Item | Needed for | Status |
| --- | --- | --- |
| **Hostinger hPanel login** | Deployment, database, SSL, cron | Received — deployed |
| **Domain registrar access** | Pointing jaipurbnb.com | Done — resolves over HTTPS |
| **SMTP credentials** | Password reset and notification email | Received — live and verified |
| **Razorpay keys** | Subscription payments | Live keys installed (`rzp_live_*`) |
| **Final logo SVG** | Replacing the text wordmark | Received — both variants in `public/img/` |
| **Real contact phone number** | Footer and contact page | Received — `CONTACT_PHONE` set, placeholder gone |
| **Business details** | Address, support hours, legal/policy copy | Received — published on the legal pages |
| **Real Airbnb iCal link** | Testing calendar sync | **Still outstanding** — see §9 |
| **Sample property photos** | Replacing placeholders | Not needed — real hosts now upload their own |

---

## 8. Handover checklist

Ticked items were verified on production on 10 September 2026.

**Code**
- [ ] Repository transferred, client has admin rights
- [ ] `main` builds cleanly from a fresh clone
- [ ] Documentation reviewed: `README`, `DEPLOYMENT.md`, `SECURITY.md`, `DATABASE.md`, `THIRD_PARTY_SERVICES.md`

**Hosting**
- [x] Deployed to Hostinger, serving over HTTPS
- [x] Cron installed and firing — confirmed in hPanel (not inspectable over SSH)
- [x] `APP_DEBUG=false`, `APP_ENV=production`
- [ ] Railway project retired

**Data**
- [x] Database decision made (fresh vs migrated) and executed — started fresh
- [x] Demo content removed — production holds only the admins and real host signups
- [x] `storage:link` working — symlink resolves, no `public/uploads` fallback needed

**Credentials**
- [ ] Client owns every password; developer holds none
- [ ] Review admin `reviewadmin@jaipurbnb.com` deleted — **still present in production**
- [ ] Anything shared during development rotated

**Domain**
- [x] jaipurbnb.com resolves to Hostinger
- [x] SSL valid, HTTP redirects to HTTPS (301)

---

## 9. Completed — status at 10 September 2026

All four milestones are built, deployed and verified on production.

**Delivered and verified on the live site:**

- **Razorpay payments** — built and wired; production keys (`rzp_live_*`)
  installed in `.env`
- **iCal sync** — `ICalSyncService` parses Airbnb `.ics` feeds and blocks
  booked dates one-way. Scheduled every 30 minutes via `Schedule::call()`
  in `routes/console.php`. The September fix: Airbnb returns **429** to
  Guzzle's default agent, so the request now sends a browser
  `User-Agent`. Note production runs `LOG_LEVEL=error`, which previously
  hid the failure.
- **Email delivery** — real SMTP (`smtp.hostinger.com:587`, TLS, from
  `noreply@jaipurbnb.com`). Confirmed sending end-to-end; the former
  `MAIL_MAILER=log` placeholder is gone.
- **Contact form** — both entry points work: the `/contact` page form and
  the site-wide "Send Us A Message" footer card. Both post to
  `ContactController`, deliver to `CONTACT_EMAIL`, and return to their own
  anchor with the correct success or error message. Mail is sent
  synchronously, so **no queue worker is required**.
- **Legal pages** — `/terms`, `/privacy`, `/refund` and `/host-terms` are
  live and carry the real registered business details. Every address on
  them reads from `config('contact.email')`, so changing `CONTACT_EMAIL`
  updates the whole site at once.
- **Contact email** — `jaipurbnb@jaipurbnb.com` throughout. No personal
  or placeholder address remains in any user-facing page.
- **Scheduler cron** — verified active in Hostinger hPanel. Note the
  `crontab` binary is absent on this host, so cron **cannot** be
  inspected over SSH; check it in hPanel.
- **Visual polish** — final logo SVGs (full and compact) in `public/img/`,
  brand palette (`#E07A5F` / `#2F3E46`, Poppins) applied throughout.
- **Security** — `APP_ENV=production`, `APP_DEBUG=false`, `.env`
  gitignored and untracked, `.env` returns 403 over HTTP, no secrets in
  tracked source, error pages leak no stack traces.

**Environment-dependent items, for the client's awareness:**

- **Live payments untested end-to-end.** Razorpay is on live keys but the
  `transactions` table is empty — no real payment has completed. Worth one
  small live transaction before hosts are invited to subscribe.
- **iCal sync not yet exercised against a real feed.** No listing has
  `ical_feed_url` set, so every run is currently a no-op. The client still
  needs to supply a real Airbnb link to prove the 429 fix end-to-end.
- **Refunds** — manual via the Razorpay dashboard, by agreement.
- **Support window** — 15 days post-delivery, bug fixes only, no new
  features.
