<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Creates the admin accounts.
 *
 * Credentials come from the environment, never from source control:
 *   ADMIN_EMAIL / ADMIN_PASSWORD / ADMIN_NAME
 *   REVIEW_ADMIN_PASSWORD           (second, review-only admin)
 *
 * 'role' is not mass-assignable (see User::$fillable), so it is set
 * explicitly here - which is the intended way to mint an admin.
 *
 * Idempotent: both accounts are keyed on email, so re-running updates in
 * place and never duplicates. Note this also means a rerun REWRITES the
 * password back to the env value - change the env var, not the password
 * in the UI, or the next deploy will undo it.
 *
 * NOTE ON env() -- Laravel returns null from env() once config has been
 * cached (php artisan config:cache), because .env is no longer read at
 * runtime. This seeder would then silently fall back to the placeholder
 * password, creating a weak account with a publicly-known credential.
 * The guard below turns that failure mode into a loud refusal instead.
 * On the Hostinger box, run the seeder BEFORE config:cache, or clear the
 * config cache first.
 */
class AdminSeeder extends Seeder
{
    private const PLACEHOLDER_PASSWORD = 'change_me_before_deploy';

    /**
     * Second admin used only for client review sessions, so the primary
     * admin password never has to be shared.
     */
    private const REVIEW_EMAIL = 'reviewadmin@jaipurbnb.com';
    private const REVIEW_NAME = 'Review Admin';
    private const REVIEW_FALLBACK_PASSWORD = 'ReviewTemp2026';

    /**
     * users.phone_number is nullable + UNIQUE (see the add_role_and_phone
     * migration), so the two admins must not share a placeholder number.
     */
    private const PRIMARY_PHONE = '+910000000000';
    private const REVIEW_PHONE = '+910000000001';

    public function run(): void
    {
        $this->runPrimaryAdmin();
        $this->runReviewAdmin();
    }

    /* ------------------------------------------------------------------ */

    private function runPrimaryAdmin(): void
    {
        $email    = env('ADMIN_EMAIL', 'admin@example.com');
        $password = env('ADMIN_PASSWORD', self::PLACEHOLDER_PASSWORD);
        $name     = env('ADMIN_NAME', 'Admin User');

        if ($password === self::PLACEHOLDER_PASSWORD) {
            $this->command->error('ADMIN_PASSWORD is not set (or config is cached, so .env is not being read).');
            $this->command->warn('Set ADMIN_EMAIL / ADMIN_PASSWORD / ADMIN_NAME in .env, run `php artisan config:clear`, then seed again.');
            $this->command->warn('Refusing to create an admin with the placeholder password.');

            return;
        }

        $admin = $this->upsertAdmin($email, $password, $name, self::PRIMARY_PHONE);

        $this->command->info("Admin ready: {$email} (role={$admin->role})");
    }

    /**
     * The review admin deliberately has a fallback password so a review
     * environment can be stood up without extra configuration. That makes
     * it a KNOWN credential whenever REVIEW_ADMIN_PASSWORD is unset - set
     * that variable on any deployment reachable from the internet, and
     * delete this account once the review window closes.
     */
    private function runReviewAdmin(): void
    {
        $password = env('REVIEW_ADMIN_PASSWORD', self::REVIEW_FALLBACK_PASSWORD);

        $review = $this->upsertAdmin(self::REVIEW_EMAIL, $password, self::REVIEW_NAME, self::REVIEW_PHONE);

        if ($password === self::REVIEW_FALLBACK_PASSWORD) {
            $this->command->warn('REVIEW_ADMIN_PASSWORD is not set - '.self::REVIEW_EMAIL.' is using the default password from source.');
        }

        $this->command->info("Review admin ready: {$review->email} (role={$review->role})");
    }

    /**
     * Create or update one admin, keyed on email.
     */
    private function upsertAdmin(string $email, string $password, string $name, string $phone): User
    {
        $admin = User::firstOrNew(['email' => $email]);

        $admin->name         = $name;
        $admin->password     = $password; // hashed by the model cast
        $admin->phone_number = $admin->phone_number ?? $this->freePhone($phone, $email);
        $admin->role         = User::ROLE_ADMIN;
        $admin->save();

        return $admin;
    }

    /**
     * A placeholder phone number nobody else is using.
     *
     * phone_number is UNIQUE, so a hardcoded placeholder blows up the whole
     * seeder the moment any other row already holds it - and because the
     * deploy start command chains seeding with && before starting the web
     * server, that failure would take the site down rather than just skip
     * an account. Walk forward until we find a free one.
     */
    private function freePhone(string $preferred, string $email): ?string
    {
        $candidate = $preferred;

        for ($i = 1; $i <= 50; $i++) {
            $owner = User::where('phone_number', $candidate)->first();

            if (! $owner || $owner->email === $email) {
                return $candidate;
            }

            $candidate = substr($preferred, 0, -1).$i;
        }

        // Nothing sensible left. NULL is allowed and, unlike '', repeated
        // NULLs do not collide under a UNIQUE index - so seeding still wins.
        return null;
    }
}
