<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'John Customer',
                'email' => 'customer@example.com',
                'phone_number' => '0771234567',
                'password' => Hash::make('password'),
                'role' => 'customer'
            ],
            [
                'name' => 'Jane Organizer',
                'email' => 'organizer@example.com',
                'phone_number' => '0777654321',
                'password' => Hash::make('password'),
                'role' => 'event_organizer'
            ],
            [
                'name' => 'Sam Inventory',
                'email' => 'inventory@example.com',
                'phone_number' => '0779876543',
                'password' => Hash::make('password'),
                'role' => 'inventory_staff'
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'phone_number' => '0779999999',
                'password' => Hash::make('admin'),
                'role' => 'admin'
            ],
        ]);
    }
}
