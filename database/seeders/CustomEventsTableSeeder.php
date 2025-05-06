<?php

namespace Database\Seeders;

use App\Models\CustomEvent;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomEventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CustomEvent::create([
            'event_request_id' => 1,
            'organizer_id' => 2,
            'finalized_date' => now()->addDays(15),
            'total_price' => 50000.00,
            'notes' => 'Includes catering and decoration',
        ]);
    }
}
