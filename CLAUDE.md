# JaipurBnB - Project Context

## Claude Code Rules
- Never run git push
- Always run git add and git commit for changes
- User will handle all pushes to remote
- Confirm before any destructive operations (delete files, 
  reset branches, force operations)

## Overview
Paid property listing directory for Jaipur only. Hosts pay a flat 
subscription to list; guests browse free and contact hosts directly 
via WhatsApp or phone. No guest payments on the platform.

## Business Model
- Host pays: Rs 799 (30 days), Rs 1,999 (90 days), Rs 6,999 (365 days)
- Payment gateway: Razorpay
- Guest contact: WhatsApp + Call only
- Booking flow: Off-platform (direct between guest and host)

## Tech Stack
- Laravel 12, PHP 8.2
- SQLite (local dev) / MySQL InnoDB (Hostinger production)
- Bootstrap 5 + Blade templates
- Vite + SCSS
- Razorpay for subscriptions
- sabre/vobject for iCal parsing
- Hostinger shared hosting (final deployment)
- Domain: jaipurbnb.com

### Laravel 12 structural notes (differs from Laravel 11)
- There is NO app/Http/Kernel.php. Middleware (including custom
  role middleware) is registered in bootstrap/app.php inside the
  ->withMiddleware(function (Middleware $middleware) { ... }) closure.
- Exception handling is configured in the ->withExceptions() closure
  of bootstrap/app.php, not app/Exceptions/Handler.php.
- The task scheduler lives in routes/console.php using
  Schedule::command(...)->daily(), NOT a Kernel::schedule() method.
- Ignore any Laravel 11-or-earlier tutorial steps referencing
  Http/Kernel.php or Console/Kernel.php - they do not apply here.

## Brand Identity
- Primary color: #E07A5F (Jaipur Terracotta)
- Secondary color: #2F3E46 (Royal Charcoal)
- Font: Poppins
- Aesthetic: Pink City Heritage

## Core Features (Full Scope)
1. Host authentication + dashboard
2. Property listing creation with up to 15 photos
3. Admin panel to approve/reject listings before going live
4. Three-state listing status: Pending Approval, Approved & Live, 
   Rejected & Refund Queue
5. Availability calendar (available, blocked, booked)
6. iCal sync: pull Airbnb .ics feeds every 30 minutes to auto-block 
   dates (one-way only, no push back)
7. Lead tracking: log every WhatsApp click, Call click, and profile 
   view; show in host dashboard
8. Daily cron job to auto-hide expired listings (is_visible = false, 
   data preserved)
9. Razorpay subscription payment flow
10. Refund flow for rejected listings (manual via Razorpay dashboard)

## Jaipur Neighborhoods (Filter Options)
Walled City, Amer, Nahargarh, C-Scheme, Civil Lines, Bani Park, 
Vaishali Nagar, Mansarovar, Malviya Nagar, Jagatpura, Raja Park, 
Pratap Nagar, Chitrakoot, Sitapura, Tonk Road, Sanganer, Jhotwara, 
Delhi Road (Kukas/Achrol), Ajmer Road (Mahapura/Bhankrota), 
Agra Road (Kanota/Jamwa Ramgarh), Chomu, Bagru

## Stay Types (Filter Options)
- Heritage Haveli / Fort Stay
- Boutique Apartment
- Luxury Villa / Farmhouse
- Homestay / Guest House
- Backpacker Hostel

## Milestones
- Milestone 1 (Day 1-7, Rs 3,600): Frontend UI - Homepage, listing 
  grid, single property page, fully responsive
- Milestone 2 (Day 8-15, Rs 5,400): Host + Admin dashboards, database, 
  auth, cron for expired listings
- Milestone 3 (Day 16-23, Rs 5,400): iCal sync (every 30 min), 
  WhatsApp/Call buttons, Razorpay integration
- Milestone 4 (Day 24-30, Rs 3,600): Hostinger deployment + bug fixing

## Database Schema (Confirmed)
Tables: users, properties, property_images, property_availability, 
lead_analytics, transactions

Key schema additions from base spec:
- properties.ical_feed_url VARCHAR(255) NULL 
  (for storing Airbnb iCal link per property)
- users.role VARCHAR(20) DEFAULT 'host' 
  (for admin panel access; values host | admin)
- properties.listing_status VARCHAR(20) DEFAULT 'pending' 
  (three-state status; values pending | approved | rejected)

NOTE: the original spec described role and listing_status as ENUM.
They are implemented as plain string/VARCHAR columns instead, so the
same migrations run on both SQLite (local dev) and MySQL (Hostinger
production). The allowed values are enforced at the model layer and
in Form Request validation, NOT by a database constraint. See
"Milestone 2 Approach" below for the full list of value sets.

## Milestone 2 Approach (Decided)

### Authentication - hand-rolled, NO starter kit
Do NOT install laravel/breeze, jetstream, fortify, or laravel/ui.
Breeze ships Tailwind views which would collide with the existing
Bootstrap 5 + custom SCSS frontend built in Milestone 1.
Build manually:
- RegisterController (host signup)
- LoginController (host + admin, distinguished by users.role)
- LogoutController
- Custom Bootstrap 5 Blade views matching the JaipurBnB design
  system (#E07A5F terracotta, #2F3E46 charcoal, Poppins)
- Custom role middleware registered in bootstrap/app.php

### Migrations - portable between SQLite and MySQL
- Local dev runs SQLite (database/database.sqlite); production on
  Hostinger runs MySQL InnoDB. All migrations must work on both.
- Use ONLY Laravel schema-builder methods. Do not write raw SQL.
- Do NOT use ->after() for column ordering - it is a MySQL-only
  modifier and is silently ignored on SQLite.
- Do NOT use native ENUM columns. SQLite has no ENUM type and
  Laravel emits varchar + CHECK, which behaves differently from
  MySQL on invalid values. Use string columns instead, with the
  allowed values enforced at BOTH the model layer (constants +
  casts) and the Form Request validation layer.

### String columns replacing ENUMs - allowed values
- users.role ......................... host | admin
- properties.listing_status .......... pending | approved | rejected
- property_availability.status ....... available | blocked | booked
- property_availability.source ....... manual | airbnb_sync
- lead_analytics.lead_type ........... whatsapp_click | call_click |
                                       profile_view
- transactions.payment_status ........ pending | success | failed |
                                       refunded

### listing_status vs is_visible - two independent axes
These are NOT the same flag and must not be merged:
- listing_status = admin moderation state (pending/approved/rejected)
- is_visible     = live-on-site flag, flipped to false by the daily
                   expiry cron when subscription_expiry passes
An expired listing stays listing_status='approved' but becomes
is_visible=false. All listing data is preserved, never deleted.

### File storage for property photos (up to 15 per listing)
- Local dev: run `php artisan storage:link` and store uploads in
  storage/app/public/properties/ (served via /storage/properties/...)
- FALLBACK FOR MILESTONE 4: Hostinger shared hosting sometimes
  blocks or strips symlinks. If public/storage does not resolve on
  the live server, switch to writing uploads directly into
  public/uploads/properties/ and update the disk config plus any
  stored image_url paths accordingly. Decide this during deployment,
  not before - do not build the fallback preemptively.

## Template Origin
Base template: Hosue Laravel v1.0 (Bootstrap 5 real estate multi-demo 
template). Contains 10 homepage demo variants, 10 single property 
variants, apartment listing pages, blog, testimonials, etc. Most demos 
are NOT needed for JaipurBnB and should be cleaned up.

## What to KEEP from Template
- layouts/base.blade.php (main layout)
- One homepage variant (to be selected and rebranded)
- One single property variant (to be selected and rebranded)
- One apartment listing/grid variant
- One navbar variant
- All SCSS/CSS build pipeline
- Bootstrap 5, jQuery, AOS, Owl Carousel, FontAwesome

## What to REMOVE from Template
- Blog section (not in scope)
- Testimonials page (not in scope)
- Gallery pages v1, v2 (not in scope)
- About page (can rebuild later if needed)
- Contact page (not in scope, contact happens per property)
- All unused demo homepage variants (keep only 1)
- All unused single property variants (keep only 1)
- All unused navbar variants (keep only 1)

## Client Communication Rules
- Client name: Rahul (Mohamed's project style, but this is JaipurBnB 
  client - confirm actual name if needed)
- Staging server: Client's Hostinger subdomain
- Client to provide: Hostinger credentials, Razorpay test keys, 
  SMTP details, real Airbnb iCal link for testing, sample property 
  photos, final logo SVG (before Milestone 4)

## Development Workflow
- Local dev on D:\uvPackage\Upwork projects\jaipurbnb
- Git remote: managed by user (Ryden)
- Main branch: main
- Deploy target: Hostinger shared hosting
- Rule: Claude Code never runs git push. User handles all pushes.

## Current Progress
Phase 1 partial:
- Colors applied (#E07A5F, #2F3E46)
- Poppins font applied
- Template building successfully with Vite
- Pushed to GitHub

Pending Phase 1:
- Homepage cleanup and Jaipur branding
- Property grid with Jaipur filters
- 3 sample property cards
- Single property page with WhatsApp + Call
- Placeholder availability calendar UI
- Remove unused template pages

## Open Items to Confirm with Client
1. Price mapping conflict resolved: Rs 799/1999/6999 confirmed as 
   final (not Rs 699/1199/5000)
2. iCal sync frequency confirmed: 30 minutes
3. Refund handling: manual via Razorpay dashboard (not automated) 
   - flag if client insists on automation
4. Support period post-delivery: to be locked at 15 days, bug fixes 
   only, no new features
