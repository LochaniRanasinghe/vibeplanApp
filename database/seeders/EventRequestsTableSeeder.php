<?php

namespace Database\Seeders;

use App\Models\EventRequest;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EventRequestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EventRequest::create([
            'customer_id' => 1,
            'event_type_id' => 1,
            'title' => 'John’s 30th Birthday',
            'description' => 'Surprise birthday party',
            'event_date' => now()->addDays(15),
            'guest_count' => 40,
            'location' => 'Colombo City Hall',
        ]);
    }
}
