<?php

namespace Database\Seeders;

use App\Models\SourcingRequest;
use App\Models\Shipment;
use Illuminate\Database\Seeder;

class ShipmentSeeder extends Seeder
{
    public function run(): void
    {
        // Shipment for request 2 (Bamboo Packaging — in transit)
        $r2 = SourcingRequest::where('title', 'Bamboo Packaging (500 units)')->first();
        if ($r2) {
            Shipment::firstOrCreate(['sourcing_request_id' => $r2->id, 'tracking_number' => 'MSCU7842601-3'], [
                'carrier' => 'MSC Shipping',
                'origin' => 'Ningbo, China',
                'destination' => 'Felixstowe, UK',
                'method' => 'sea',
                'status' => 'in_transit',
                'estimated_arrival' => now()->addDays(12)->toDateString(),
            ]);
        }

        // Shipment for request 3 (Water Bottles — delivered)
        $r3 = SourcingRequest::where('title', 'Stainless Steel Water Bottles (1000 units)')->first();
        if ($r3) {
            Shipment::firstOrCreate(['sourcing_request_id' => $r3->id, 'tracking_number' => 'EMS123456789CN'], [
                'carrier' => 'DHL Express',
                'origin' => 'Yongkang, China',
                'destination' => 'London, UK',
                'method' => 'air',
                'status' => 'delivered',
                'estimated_arrival' => now()->subDays(5)->toDateString(),
            ]);
        }

        // Additional shipment for request 5 (Organic Cotton T-Shirts — pending shipment)
        $r5 = SourcingRequest::where('title', 'Organic Cotton T-Shirts (5000 units)')->first();
        if ($r5) {
            Shipment::firstOrCreate(['sourcing_request_id' => $r5->id, 'tracking_number' => 'COSCO88834-2'], [
                'carrier' => 'COSCO Shipping',
                'origin' => 'Shanghai, China',
                'destination' => 'Hamburg, Germany',
                'method' => 'sea',
                'status' => 'pending',
                'estimated_arrival' => now()->addDays(45)->toDateString(),
            ]);
        }
    }
}
