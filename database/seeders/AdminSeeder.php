<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Creates the initial admin account for testing the approval panel.
 *
 * 'role' is not mass-assignable (see User::$fillable), so it is set
 * explicitly here - which is exactly the intended way to mint an admin.
 *
 * Idempotent: safe to re-run, it will not duplicate the account.
 *
 * WARNING: these are development credentials. Change the password before
 * the Hostinger deployment in Milestone 4.
 */
class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrNew(['email' => 'admin@jaipurbnb.com']);

        $admin->name         = 'JaipurBnB Admin';
        $admin->password     = 'admin12345'; // hashed by the model cast
        $admin->phone_number = $admin->phone_number ?? '+910000000000';
        $admin->role         = User::ROLE_ADMIN;
        $admin->save();

        $this->command->info("Admin ready: admin@jaipurbnb.com / admin12345 (role={$admin->role})");
    }
}
