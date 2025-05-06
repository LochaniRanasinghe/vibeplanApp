<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Payment::create([
            'customer_id' => 1,
            'custom_event_id' => 1,
            'amount' => 50000.00,
            'payment_method' => 'Credit Card',
            'payment_status' => 'paid',
            'paid_at' => now()
        ]);
    }
}
