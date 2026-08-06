# Handover

How JaipurBnB transfers into the client's ownership: code, database,
uploaded photos, hosting, credentials and domain.

Railway is **staging only**. Production is a fresh deployment to the
client's Hostinger account — nothing is "moved" from Railway except the
code, which lives in Git.

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

Ideally before Milestone 4 starts:

| Item | Needed for |
| --- | --- |
| **Hostinger hPanel login** | Deployment, database, SSL, cron |
| **Domain registrar access** | Pointing jaipurbnb.com |
| **SMTP credentials** | Password reset and notification email |
| **Razorpay keys** (test, then production) | Milestone 3 subscription payments |
| **Real Airbnb iCal link** | Testing calendar sync |
| **Final logo SVG** | Replacing the text wordmark |
| **Real contact phone number** | Footer and contact page currently show a clearly-labelled `(demo)` placeholder |
| **Sample property photos** | Replacing picsum placeholders |
| **Business details** | Address, support hours, any legal/policy copy |

---

## 8. Handover checklist

**Code**
- [ ] Repository transferred, client has admin rights
- [ ] `main` builds cleanly from a fresh clone
- [ ] Documentation reviewed: `README`, `DEPLOYMENT.md`, `SECURITY.md`, `DATABASE.md`, `THIRD_PARTY_SERVICES.md`

**Hosting**
- [ ] Deployed to Hostinger, serving over HTTPS
- [ ] Cron installed and firing
- [ ] `APP_DEBUG=false`, `APP_ENV=production`
- [ ] Railway project retired

**Data**
- [ ] Database decision made (fresh vs migrated) and executed
- [ ] Demo content removed
- [ ] `storage:link` working, or the `public/uploads` fallback in place

**Credentials**
- [ ] Client owns every password; developer holds none
- [ ] Review admin deleted
- [ ] Anything shared during development rotated

**Domain**
- [ ] jaipurbnb.com resolves to Hostinger
- [ ] SSL valid, HTTP redirects to HTTPS

---

## 9. Outstanding work at time of writing

So the handover is not mistaken for feature-complete:

- **Razorpay payments** — not built (Milestone 3)
- **iCal sync** — not built; schema is ready, no parser or scheduled command
- **Email delivery** — `MAIL_MAILER=log`, needs real SMTP
- **Refunds** — manual via the Razorpay dashboard, by agreement
- **Support window** — 15 days post-delivery, bug fixes only, no new features
