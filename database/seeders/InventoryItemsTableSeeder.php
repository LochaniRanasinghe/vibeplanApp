<?php

namespace Database\Seeders;

use App\Models\InventoryItem;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InventoryItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InventoryItem::insert([
            ['inventory_staff_id' => 3, 'item_name' => 'Chairs', 'description' => 'Plastic chairs', 'quantity_available' => 100, 'price_per_unit' => 2.50],
            ['inventory_staff_id' => 3, 'item_name' => 'Tables', 'description' => 'Wooden tables', 'quantity_available' => 30, 'price_per_unit' => 10.00],
        ]);
    }
}
