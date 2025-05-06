<?php

namespace Database\Seeders;

use App\Models\EventType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EventTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EventType::insert([
            ['name' => 'Birthday', 'description' => 'Birthday party event', 'min_guests' => 10, 'max_guests' => 100],
            ['name' => 'Wedding', 'description' => 'Wedding ceremony and reception', 'min_guests' => 50, 'max_guests' => 300],
            ['name' => 'Corporate', 'description' => 'Corporate conferences and meetings', 'min_guests' => 20, 'max_guests' => 200],
        ]);
    }
}
