<?php
namespace Database\Seeders;
use App\Models\User;
use App\Models\SourcingRequest;
use App\Models\Quote;
use App\Models\Shipment;
use App\Models\Document;
use App\Models\Message;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        // Demo user
        $user = User::firstOrCreate(['email' => 'demo@trivalo.com'], [
            'name'     => 'James Thornton',
            'company'  => 'Thornton Brands Ltd.',
            'phone'    => '+44 7700 900123',
            'country'  => 'United Kingdom',
            'password' => Hash::make('password'),
        ]);

        // Request 1 — quoted
        $r1 = SourcingRequest::create([
            'user_id' => $user->id, 'status' => 'quoted',
            'title' => 'Custom Bluetooth Earbuds (Private Label)',
            'description' => 'TWS Bluetooth 5.3 earbuds with custom logo on case and buds. Requires CE and FCC certification. Black colorway.',
            'quantity' => 500, 'target_price' => 12.00, 'currency' => 'USD',
            'destination_country' => 'United Kingdom', 'deadline' => now()->addDays(45)->toDateString(),
        ]);
        Quote::create(['sourcing_request_id' => $r1->id, 'supplier_name' => 'Shenzhen AudioTech Co.', 'unit_price' => 10.80, 'total_price' => 5400, 'currency' => 'USD', 'moq' => 500, 'lead_time' => '18–22 days', 'status' => 'pending', 'notes' => 'CE & FCC certified. Custom logo included. Sample available.']);
        Quote::create(['sourcing_request_id' => $r1->id, 'supplier_name' => 'Guangzhou SoundPro Ltd.', 'unit_price' => 9.50, 'total_price' => 4750, 'currency' => 'USD', 'moq' => 500, 'lead_time' => '25–30 days', 'status' => 'pending', 'notes' => 'CE certified only. FCC in progress. Good track record with EU clients.']);
        Message::create(['sourcing_request_id' => $r1->id, 'user_id' => null, 'is_from_team' => true, 'body' => 'Hi James! We found 2 strong candidates. Shenzhen AudioTech is slightly pricier but has both CE & FCC — ideal for UK/US markets. Let us know if you need samples before deciding.']);
        Message::create(['sourcing_request_id' => $r1->id, 'user_id' => $user->id, 'is_from_team' => false, 'body' => 'Thanks! Let\'s go with AudioTech. Can we get a sample before approving the quote?']);

        // Request 2 — in transit
        $r2 = SourcingRequest::create([
            'user_id' => $user->id, 'status' => 'shipped',
            'title' => 'Bamboo Packaging (500 units)',
            'description' => 'Eco-friendly bamboo gift boxes, 20x15x8cm, with magnetic closure and custom insert for electronics.',
            'quantity' => 500, 'target_price' => 4.50, 'currency' => 'USD',
            'destination_country' => 'United Kingdom', 'deadline' => now()->addDays(10)->toDateString(),
        ]);
        Quote::create(['sourcing_request_id' => $r2->id, 'supplier_name' => 'Zhejiang GreenPack', 'unit_price' => 3.90, 'total_price' => 1950, 'currency' => 'USD', 'moq' => 300, 'lead_time' => '15 days', 'status' => 'approved']);
        Shipment::create(['sourcing_request_id' => $r2->id, 'tracking_number' => 'MSCU7842601-3', 'carrier' => 'MSC Shipping', 'origin' => 'Ningbo, China', 'destination' => 'Felixstowe, UK', 'method' => 'sea', 'status' => 'in_transit', 'estimated_arrival' => now()->addDays(12)->toDateString()]);
        Document::create(['sourcing_request_id' => $r2->id, 'name' => 'Pre-Shipment Inspection Report', 'type' => 'inspection_report', 'size' => 1240000]);
        Document::create(['sourcing_request_id' => $r2->id, 'name' => 'Bill of Lading', 'type' => 'packing_list', 'size' => 340000]);
        Document::create(['sourcing_request_id' => $r2->id, 'name' => 'Certificate of Origin', 'type' => 'certificate_of_origin', 'size' => 210000]);
        Message::create(['sourcing_request_id' => $r2->id, 'user_id' => null, 'is_from_team' => true, 'body' => 'Your shipment departed Ningbo on schedule. Tracking number: MSCU7842601-3. ETA Felixstowe is ' . now()->addDays(12)->format('M j, Y') . '. Documents attached above.']);

        // Request 3 — delivered
        $r3 = SourcingRequest::create([
            'user_id' => $user->id, 'status' => 'delivered',
            'title' => 'Stainless Steel Water Bottles (1000 units)',
            'description' => 'Double-wall vacuum insulated 500ml bottles with custom logo engraving.',
            'quantity' => 1000, 'target_price' => 6.00, 'currency' => 'USD',
            'destination_country' => 'United Kingdom',
        ]);
        Quote::create(['sourcing_request_id' => $r3->id, 'supplier_name' => 'Yongkang Hydro Co.', 'unit_price' => 5.40, 'total_price' => 5400, 'currency' => 'USD', 'moq' => 500, 'lead_time' => '20 days', 'status' => 'approved']);
        Shipment::create(['sourcing_request_id' => $r3->id, 'tracking_number' => 'EMS123456789CN', 'carrier' => 'DHL Express', 'origin' => 'Yongkang, China', 'destination' => 'London, UK', 'method' => 'air', 'status' => 'delivered', 'estimated_arrival' => now()->subDays(5)->toDateString()]);
        Document::create(['sourcing_request_id' => $r3->id, 'name' => 'Final Inspection Report', 'type' => 'inspection_report', 'size' => 2100000]);
        Document::create(['sourcing_request_id' => $r3->id, 'name' => 'Commercial Invoice', 'type' => 'invoice', 'size' => 180000]);

        echo "Demo data seeded. Login: demo@trivalo.com / password\n";
    }
}
