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
                'email' => 'admin@test.com',
                'password' => Hash::make('admin123'),
                'is_active' => true,
                'verified' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        echo "Admin user created successfully!\n";
        echo "Email: admin@test.com\n";
        echo "Password: admin123\n";
    }
}
