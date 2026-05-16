<?php

namespace Database\Seeders;

use App\Models\SourcingRequest;
use App\Models\Quote;
use Illuminate\Database\Seeder;

class QuoteSeeder extends Seeder
{
    public function run(): void
    {
        // Quotes for request 1 (Bluetooth Earbuds)
        $r1 = SourcingRequest::where('title', 'Custom Bluetooth Earbuds (Private Label)')->first();
        if ($r1) {
            Quote::firstOrCreate(['sourcing_request_id' => $r1->id, 'supplier_name' => 'Shenzhen AudioTech Co.'], [
                'unit_price' => 10.80,
                'total_price' => 5400,
                'currency' => 'USD',
                'moq' => 500,
                'lead_time' => '18–22 days',
                'status' => 'pending',
                'notes' => 'CE & FCC certified. Custom logo included. Sample available.',
            ]);

            Quote::firstOrCreate(['sourcing_request_id' => $r1->id, 'supplier_name' => 'Guangzhou SoundPro Ltd.'], [
                'unit_price' => 9.50,
                'total_price' => 4750,
                'currency' => 'USD',
                'moq' => 500,
                'lead_time' => '25–30 days',
                'status' => 'pending',
                'notes' => 'CE certified only. FCC in progress. Good track record with EU clients.',
            ]);
        }

        // Quotes for request 2 (Bamboo Packaging)
        $r2 = SourcingRequest::where('title', 'Bamboo Packaging (500 units)')->first();
        if ($r2) {
            Quote::firstOrCreate(['sourcing_request_id' => $r2->id, 'supplier_name' => 'Zhejiang GreenPack'], [
                'unit_price' => 3.90,
                'total_price' => 1950,
                'currency' => 'USD',
                'moq' => 300,
                'lead_time' => '15 days',
                'status' => 'approved',
                'notes' => 'Eco-friendly certified. Fast production and delivery.',
            ]);
        }

        // Quotes for request 3 (Water Bottles)
        $r3 = SourcingRequest::where('title', 'Stainless Steel Water Bottles (1000 units)')->first();
        if ($r3) {
            Quote::firstOrCreate(['sourcing_request_id' => $r3->id, 'supplier_name' => 'Yongkang Hydro Co.'], [
                'unit_price' => 5.40,
                'total_price' => 5400,
                'currency' => 'USD',
                'moq' => 500,
                'lead_time' => '20 days',
                'status' => 'approved',
                'notes' => 'High-quality vacuum insulation. Custom engraving available.',
            ]);
        }

        // Quotes for request 4 (LED Gaming Mouse)
        $r4 = SourcingRequest::where('title', 'LED Gaming Mouse (2000 units)')->first();
        if ($r4) {
            Quote::firstOrCreate(['sourcing_request_id' => $r4->id, 'supplier_name' => 'Shenzhen TechGaming Co.'], [
                'unit_price' => 7.20,
                'total_price' => 14400,
                'currency' => 'USD',
                'moq' => 1000,
                'lead_time' => '30–35 days',
                'status' => 'pending',
                'notes' => 'RGB LED customizable. 16k DPI sensor. CE & FCC approved.',
            ]);

            Quote::firstOrCreate(['sourcing_request_id' => $r4->id, 'supplier_name' => 'Dongguan PeripheralsPro'], [
                'unit_price' => 6.80,
                'total_price' => 13600,
                'currency' => 'USD',
                'moq' => 1000,
                'lead_time' => '28–32 days',
                'status' => 'pending',
                'notes' => 'Competitive pricing. Good warranty support.',
            ]);
        }

        // Quotes for request 5 (Organic Cotton T-Shirts)
        $r5 = SourcingRequest::where('title', 'Organic Cotton T-Shirts (5000 units)')->first();
        if ($r5) {
            Quote::firstOrCreate(['sourcing_request_id' => $r5->id, 'supplier_name' => 'Jiangsu EcoTextiles'], [
                'unit_price' => 3.50,
                'total_price' => 17500,
                'currency' => 'USD',
                'moq' => 1000,
                'lead_time' => '35–40 days',
                'status' => 'pending',
                'notes' => 'GOTS certified. Premium quality. Custom printing included.',
            ]);

            Quote::firstOrCreate(['sourcing_request_id' => $r5->id, 'supplier_name' => 'Shanghai TextileImports'], [
                'unit_price' => 3.20,
                'total_price' => 16000,
                'currency' => 'USD',
                'moq' => 2000,
                'lead_time' => '40–45 days',
                'status' => 'pending',
                'notes' => 'Eco-friendly. Fast turnaround available for extra cost.',
            ]);
        }
    }
}
