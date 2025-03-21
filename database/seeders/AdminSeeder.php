<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        DB::table('admins')->insert([
            'id' => 1,
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'email_verified_at' => null,
            'password' => Hash::make('admin1234'),
            'remember_token' => 'randomtoken123',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
