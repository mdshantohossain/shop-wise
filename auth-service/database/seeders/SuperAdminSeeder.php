<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate([
            'name' => 'Md Shanto Hossain',
            'email' => 'administrator@shopwise.com',
            'phone' => '+8801799630818',
            'password' => bcrypt('password'),
            'role' => 'system',
            'status' => 1,
        ]);

        User::firstOrCreate([
            'name' => 'Test User',
            'email' => 'test@gmail.com',
            'phone' => '+8801799630818',
            'password' => bcrypt('password'),
            'role' => 'user',
            'status' => 1,
        ]);
    }
}
