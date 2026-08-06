# Third-party services and libraries

Everything JaipurBnB depends on outside its own code, and whether each
one is needed in production or is demo scaffolding to be removed.

Status key:

| Status | Meaning |
| --- | --- |
| **Live** | Installed and used in the running application |
| **Demo only** | Present for the client review; must be replaced or removed before launch |
| **Planned** | Named in the project scope but **not installed** in this repository yet |

---

## Hosted services

| Service | Purpose | Status | Notes |
| --- | --- | --- | --- |
| **Railway** | Staging host + MySQL | **Demo only** | `serene-analysis` project. Staging for client review; production is Hostinger. No storage volume, so uploads do not survive redeploys. |
| **Hostinger** | Production host | Planned | Shared hosting, MySQL InnoDB. Client provides hPanel access. |
| **Google Fonts** | Poppins typeface | **Live** | Loaded from `fonts.googleapis.com` in `layouts/partials/title-meta.blade.php`. Requires internet at page load. Self-host if that is unacceptable. |
| **picsum.photos** | Placeholder listing photos | **Demo only** | Used by `SamplePropertySeeder` for the six demo listings, because Railway has no persistent storage. **Third-party dependency — if picsum is slow or down, demo images break.** Replaced automatically once hosts upload real photos. |
| **Razorpay** | Host subscription payments | **Planned** | Milestone 3. **No SDK, no keys and no payment code exist in this repository yet.** Test-mode keys come from the client. |
| **Airbnb iCal feeds** | Pull `.ics` to auto-block dates | **Planned** | Milestone 3. The schema is ready (`properties.ical_feed_url`, `property_availability.source = 'airbnb_sync'`) but nothing writes those rows yet. |
| **SMTP provider** | Password reset + notification email | **Planned** | `MAIL_MAILER=log` today — reset links are written to `storage/logs/laravel.log`, not delivered. Client supplies credentials. |
| **WhatsApp (wa.me)** | Guest → host contact | **Live** | Plain `https://wa.me/91...` deep links. No API, no account, no cost. |

---

## Composer packages (PHP)

Direct production requirements — the full resolved tree is in
`composer.lock`.

| Package | Version | Purpose | Status |
| --- | --- | --- | --- |
| `php` | `^8.2` | Runtime | **Live** |
| `ext-mbstring` | `*` | Multibyte strings | **Live** |
| `ext-pdo_mysql` | `*` | MySQL driver | **Live** — declared explicitly because the Railway builder derives the runtime image's PHP extensions from `composer.json` |
| `laravel/framework` | `^12.0` | Framework | **Live** |
| `laravel/tinker` | `^2.10.1` | REPL | **Live** (dev convenience; harmless in production) |

Dev-only: `fakerphp/faker`, `laravel/pail`, `laravel/pint`,
`laravel/sail`, `mockery/mockery`, `nunomaduro/collision`,
`phpunit/phpunit`. Excluded by `composer install --no-dev`.

### Not installed, despite appearing in the project scope

- **`sabre/vobject`** — named in `CLAUDE.md` for iCal parsing. It is
  **not** in `composer.json` and not installed. (`composer.lock` contains
  the string `sabre/dav` only as an incidental mention inside another
  package's metadata, not as a dependency.) Milestone 3 work.
- **Razorpay PHP SDK** — not installed.

---

## npm packages (front end)

Production dependencies, bundled by Vite into `public/build/`:

| Package | Version | Purpose | Status |
| --- | --- | --- | --- |
| `bootstrap` | `^5.3.5` | UI framework, offcanvas mobile nav | **Live** |
| `@popperjs/core` | `^2.11.8` | Bootstrap dropdown/tooltip positioning | **Live** |
| `jquery` | `^3.7.1` | Required by the template's plugins | **Live** |
| `owl.carousel` | `2.3.4` | Homepage hero carousel | **Live** |
| `aos` | `^2.3.4` | Scroll animations | **Live** |
| `@fortawesome/fontawesome-free` | `^6.7.2` | Icons (self-hosted, no CDN) | **Live** |
| `magnific-popup` | `1.1.0` | Video lightbox | **Live** |
| `slick-slider` | `^1.8.2` | Testimonial slider | **Live** |
| `gsap` | `^3.12.7` | Template animations | **Live** |
| `waypoints` | `^4.0.1` | Scroll triggers | **Live** |
| `countup.js` | `^2.8.0` | Animated counters | **Live** |
| `jquery-circle-progress` | `^1.2.2` | Circular progress rings | **Live** |

Dev dependencies: `vite`, `laravel-vite-plugin`, `sass`, `concurrently`,
`axios`.

> **`axios` is unused.** It ships in Laravel's default `package.json` but
> no application code imports it — a grep for `axios` across `resources/`
> returns nothing. It is a dev dependency, so it is not bundled into the
> production build. Safe to remove.

---

## CDN dependencies

Only one asset is fetched from a third-party CDN at page load:

- **Google Fonts — Poppins.** `fonts.googleapis.com` +
  `fonts.gstatic.com`.

Everything else — Bootstrap, jQuery, Font Awesome, all carousels — is
installed via npm and bundled locally. There is no runtime dependency on
jsDelivr, unpkg or cdnjs in the rendered pages.

> One historical note: `resources/scss/main.scss` still carries an
> `@import 'https://unpkg.com/swiper/swiper-bundle.min.css'`. That is
> resolved **at build time** and inlined into the compiled CSS, so it is
> not a runtime CDN call — but it does mean the build machine needs
> internet access, and Swiper is not otherwise used. A candidate for
> removal.

---

## Costs

| Item | Cost |
| --- | --- |
| Google Fonts | Free |
| picsum.photos | Free (demo only) |
| WhatsApp deep links | Free |
| npm / Composer packages | Free, open source |
| Railway | Usage-based; staging only, retire after handover |
| Hostinger | Client's existing plan |
| Razorpay | Per-transaction fee once live |
| SMTP | Depends on client's provider |

---

## Removal checklist before production launch

- [ ] Remove `SamplePropertySeeder` from the `railpack.json` start command
- [ ] Replace all picsum placeholder images with real host uploads
- [ ] Delete the demo host account (`demohost@jaipurbnb.com`)
- [ ] Delete the review admin (`reviewadmin@jaipurbnb.com`)
- [ ] Replace `MAIL_MAILER=log` with real SMTP
- [ ] Remove the unused `swiper` CDN import from `main.scss`
- [ ] Consider removing the unused `axios` dev dependency
- [ ] Retire the Railway project once Hostinger is live
