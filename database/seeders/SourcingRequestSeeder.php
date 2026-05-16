<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SourcingRequest;
use Illuminate\Database\Seeder;

class SourcingRequestSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'demo@trivalo.com')->first();
        
        if (!$user) {
            return;
        }

        // Request 1 — quoted
        SourcingRequest::firstOrCreate(['title' => 'Custom Bluetooth Earbuds (Private Label)'], [
            'user_id' => $user->id,
            'status' => 'quoted',
            'description' => 'TWS Bluetooth 5.3 earbuds with custom logo on case and buds. Requires CE and FCC certification. Black colorway.',
            'quantity' => 500,
            'target_price' => 12.00,
            'currency' => 'USD',
            'destination_country' => 'United Kingdom',
            'deadline' => now()->addDays(45)->toDateString(),
        ]);

        // Request 2 — in transit / shipped
        SourcingRequest::firstOrCreate(['title' => 'Bamboo Packaging (500 units)'], [
            'user_id' => $user->id,
            'status' => 'shipped',
            'description' => 'Eco-friendly bamboo gift boxes, 20x15x8cm, with magnetic closure and custom insert for electronics.',
            'quantity' => 500,
            'target_price' => 4.50,
            'currency' => 'USD',
            'destination_country' => 'United Kingdom',
            'deadline' => now()->addDays(10)->toDateString(),
        ]);

        // Request 3 — delivered
        SourcingRequest::firstOrCreate(['title' => 'Stainless Steel Water Bottles (1000 units)'], [
            'user_id' => $user->id,
            'status' => 'delivered',
            'description' => 'Double-wall vacuum insulated 500ml bottles with custom logo engraving.',
            'quantity' => 1000,
            'target_price' => 6.00,
            'currency' => 'USD',
            'destination_country' => 'United Kingdom',
        ]);

        // Request 4 — pending
        SourcingRequest::firstOrCreate(['title' => 'LED Gaming Mouse (2000 units)'], [
            'user_id' => $user->id,
            'status' => 'pending',
            'description' => 'RGB LED gaming mouse with programmable buttons, 16k DPI sensor. Requires compliance with gaming standards.',
            'quantity' => 2000,
            'target_price' => 8.50,
            'currency' => 'USD',
            'destination_country' => 'United States',
            'deadline' => now()->addDays(60)->toDateString(),
        ]);

        // Request 5 — confirmed
        SourcingRequest::firstOrCreate(['title' => 'Organic Cotton T-Shirts (5000 units)'], [
            'user_id' => $user->id,
            'status' => 'confirmed',
            'description' => 'Premium organic cotton t-shirts, various colors. GOTS certified. Custom tags and labeling.',
            'quantity' => 5000,
            'target_price' => 4.00,
            'currency' => 'USD',
            'destination_country' => 'Germany',
            'deadline' => now()->addDays(90)->toDateString(),
        ]);
    }
}
