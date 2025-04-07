<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Important: RoleSeeder must run before UserSeeder
        // because users depend on roles
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}