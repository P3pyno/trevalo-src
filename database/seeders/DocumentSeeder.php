<?php

namespace Database\Seeders;

use App\Models\SourcingRequest;
use App\Models\Document;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    public function run(): void
    {
        // Documents for request 2 (Bamboo Packaging)
        $r2 = SourcingRequest::where('title', 'Bamboo Packaging (500 units)')->first();
        if ($r2) {
            Document::firstOrCreate(['sourcing_request_id' => $r2->id, 'name' => 'Pre-Shipment Inspection Report'], [
                'type' => 'inspection_report',
                'size' => 1240000,
            ]);

            Document::firstOrCreate(['sourcing_request_id' => $r2->id, 'name' => 'Bill of Lading'], [
                'type' => 'packing_list',
                'size' => 340000,
            ]);

            Document::firstOrCreate(['sourcing_request_id' => $r2->id, 'name' => 'Certificate of Origin'], [
                'type' => 'certificate_of_origin',
                'size' => 210000,
            ]);
        }

        // Documents for request 3 (Water Bottles)
        $r3 = SourcingRequest::where('title', 'Stainless Steel Water Bottles (1000 units)')->first();
        if ($r3) {
            Document::firstOrCreate(['sourcing_request_id' => $r3->id, 'name' => 'Final Inspection Report'], [
                'type' => 'inspection_report',
                'size' => 2100000,
            ]);

            Document::firstOrCreate(['sourcing_request_id' => $r3->id, 'name' => 'Commercial Invoice'], [
                'type' => 'invoice',
                'size' => 180000,
            ]);

            Document::firstOrCreate(['sourcing_request_id' => $r3->id, 'name' => 'Product Quality Certificate'], [
                'type' => 'certificate_of_origin',
                'size' => 520000,
            ]);
        }

        // Documents for request 4 (LED Gaming Mouse)
        $r4 = SourcingRequest::where('title', 'LED Gaming Mouse (2000 units)')->first();
        if ($r4) {
            Document::firstOrCreate(['sourcing_request_id' => $r4->id, 'name' => 'Technical Specifications'], [
                'type' => 'invoice',
                'size' => 890000,
            ]);

            Document::firstOrCreate(['sourcing_request_id' => $r4->id, 'name' => 'CE Certification'], [
                'type' => 'certificate_of_origin',
                'size' => 1200000,
            ]);

            Document::firstOrCreate(['sourcing_request_id' => $r4->id, 'name' => 'FCC Compliance Report'], [
                'type' => 'certificate_of_origin',
                'size' => 1500000,
            ]);
        }

        // Documents for request 5 (Organic Cotton T-Shirts)
        $r5 = SourcingRequest::where('title', 'Organic Cotton T-Shirts (5000 units)')->first();
        if ($r5) {
            Document::firstOrCreate(['sourcing_request_id' => $r5->id, 'name' => 'GOTS Certification'], [
                'type' => 'certificate_of_origin',
                'size' => 980000,
            ]);

            Document::firstOrCreate(['sourcing_request_id' => $r5->id, 'name' => 'Material Test Report'], [
                'type' => 'invoice',
                'size' => 1560000,
            ]);

            Document::firstOrCreate(['sourcing_request_id' => $r5->id, 'name' => 'Lab Testing Certificates'], [
                'type' => 'inspection_report',
                'size' => 2340000,
            ]);
        }
    }
}
