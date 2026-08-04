<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Creates the initial admin account.
 *
 * Credentials come from the environment, never from source control:
 *   ADMIN_EMAIL / ADMIN_PASSWORD / ADMIN_NAME
 *
 * 'role' is not mass-assignable (see User::$fillable), so it is set
 * explicitly here - which is the intended way to mint an admin.
 *
 * Idempotent: safe to re-run, it will not duplicate the account.
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

    public function run(): void
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

        $admin = User::firstOrNew(['email' => $email]);

        $admin->name         = $name;
        $admin->password     = $password; // hashed by the model cast
        $admin->phone_number = $admin->phone_number ?? '+910000000000';
        $admin->role         = User::ROLE_ADMIN;
        $admin->save();

        $this->command->info("Admin ready: {$email} (role={$admin->role})");
    }
}
