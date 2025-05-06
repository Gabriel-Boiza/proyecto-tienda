<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->truncate();

        DB::table('users')->insert([
            'nick' => 'admin',
            'pass' => Hash::make('admin'), 
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}