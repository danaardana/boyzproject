<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->updateOrInsert(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Test Admin',
                'email' => 'test@newdomain.com',
                'password' => Hash::make('password'),
                'is_active' => true,
                'verified' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        echo "Admin user created successfully!\n";
        echo "Email: test@newdomain.com\n";
        echo "Password: password\n";
    }
}
