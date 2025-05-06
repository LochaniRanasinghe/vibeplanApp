<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\PaymentsTableSeeder;
use Database\Seeders\EventTypesTableSeeder;
use Database\Seeders\CustomEventsTableSeeder;
use Database\Seeders\EventRequestsTableSeeder;
use Database\Seeders\InventoryItemsTableSeeder;
use Database\Seeders\EventInventoryOrdersTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            EventTypesTableSeeder::class,
            InventoryItemsTableSeeder::class,
            EventRequestsTableSeeder::class,
            CustomEventsTableSeeder::class,
            PaymentsTableSeeder::class,
            EventInventoryOrdersTableSeeder::class,
        ]);
    }
}
