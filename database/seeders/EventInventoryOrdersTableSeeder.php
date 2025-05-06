<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EventInventoryOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EventInventoryOrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EventInventoryOrder::create([
            'custom_event_id' => 1,
            'inventory_item_id' => 1,
            'quantity' => 40,
            'status' => 'approved'
        ]);
    }
}
