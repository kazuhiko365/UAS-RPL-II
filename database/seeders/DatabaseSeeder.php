<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Sport;
use App\Models\Venue;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin: create or update existing admin user (idempotent)
        // UPDATE: Menggunakan kredensial baru 'admin@sportclub.id'
        $adminEmail = 'admin@sportclub.id';

        $admin = User::updateOrCreate([
            'email' => $adminEmail,
        ], [
            'name' => 'Super Admin',
            'password' => Hash::make('admin123'), // Password Baru
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $this->command->info('Admin User created/updated: ' . $adminEmail);

        // 2. Call Specialized Seeders
        // VenueSeeder: Mengisi data Venues lengkap (Bandung, Jakarta, dll)
        // VenueSportSeeder: Mengisi Sports dan menghubungkannya dengan Venues (Logic Mapping)
        $this->call([
            VenueSeeder::class,
            VenueSportSeeder::class,
        ]);
    }
}