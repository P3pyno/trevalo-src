<?php

namespace Database\Seeders;

use App\Models\SourcingRequest;
use App\Models\User;
use App\Models\Message;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'demo@trivalo.com')->first();
        
        if (!$user) {
            return;
        }

        // Messages for request 1 (Bluetooth Earbuds)
        $r1 = SourcingRequest::where('title', 'Custom Bluetooth Earbuds (Private Label)')->first();
        if ($r1) {
            Message::firstOrCreate(['sourcing_request_id' => $r1->id, 'body' => 'Hi James! We found 2 strong candidates.'], [
                'user_id' => null,
                'is_from_team' => true,
            ]);

            Message::firstOrCreate(['sourcing_request_id' => $r1->id, 'body' => 'Shenzhen AudioTech is slightly pricier but has both CE & FCC — ideal for UK/US markets. Let us know if you need samples before deciding.'], [
                'user_id' => null,
                'is_from_team' => true,
            ]);

            Message::firstOrCreate(['sourcing_request_id' => $r1->id, 'body' => 'Thanks! Let\'s go with AudioTech. Can we get a sample before approving the quote?'], [
                'user_id' => $user->id,
                'is_from_team' => false,
            ]);

            Message::firstOrCreate(['sourcing_request_id' => $r1->id, 'body' => 'Perfect! We\'ll request a sample immediately. Expect it within 7-10 business days via DHL Express.'], [
                'user_id' => null,
                'is_from_team' => true,
            ]);
        }

        // Messages for request 2 (Bamboo Packaging)
        $r2 = SourcingRequest::where('title', 'Bamboo Packaging (500 units)')->first();
        if ($r2) {
            Message::firstOrCreate(['sourcing_request_id' => $r2->id, 'body' => 'Your quotation request has been sent to 3 certified eco-friendly suppliers.'], [
                'user_id' => null,
                'is_from_team' => true,
            ]);

            Message::firstOrCreate(['sourcing_request_id' => $r2->id, 'body' => 'We received excellent quotes. Zhejiang GreenPack offers the best value at $3.90/unit. Quote approved and production started!'], [
                'user_id' => null,
                'is_from_team' => true,
            ]);

            Message::firstOrCreate(['sourcing_request_id' => $r2->id, 'body' => 'Great! Keep me updated on production status.'], [
                'user_id' => $user->id,
                'is_from_team' => false,
            ]);

            Message::firstOrCreate(['sourcing_request_id' => $r2->id, 'body' => 'Your shipment departed Ningbo on schedule. Tracking: MSCU7842601-3. ETA Felixstowe is ' . now()->addDays(12)->format('M j, Y') . '. Documents attached.'], [
                'user_id' => null,
                'is_from_team' => true,
            ]);
        }

        // Messages for request 3 (Water Bottles)
        $r3 = SourcingRequest::where('title', 'Stainless Steel Water Bottles (1000 units)')->first();
        if ($r3) {
            Message::firstOrCreate(['sourcing_request_id' => $r3->id, 'body' => 'Quote approved and shipment completed. Your water bottles arrived at London warehouse on ' . now()->subDays(5)->format('M j, Y') . '.'], [
                'user_id' => null,
                'is_from_team' => true,
            ]);

            Message::firstOrCreate(['sourcing_request_id' => $r3->id, 'body' => 'Inspected all 1000 units. Quality is excellent. All custom engraving is perfect. Ready for retail.'], [
                'user_id' => null,
                'is_from_team' => true,
            ]);

            Message::firstOrCreate(['sourcing_request_id' => $r3->id, 'body' => 'Excellent work! Please proceed with packaging and labeling for distribution.'], [
                'user_id' => $user->id,
                'is_from_team' => false,
            ]);
        }

        // Messages for request 4 (LED Gaming Mouse)
        $r4 = SourcingRequest::where('title', 'LED Gaming Mouse (2000 units)')->first();
        if ($r4) {
            Message::firstOrCreate(['sourcing_request_id' => $r4->id, 'body' => 'Request submitted to 2 leading gaming peripherals manufacturers.'], [
                'user_id' => null,
                'is_from_team' => true,
            ]);

            Message::firstOrCreate(['sourcing_request_id' => $r4->id, 'body' => 'Both suppliers have competitive bids. Shenzhen TechGaming has both CE & FCC pre-approved. Decision pending.'], [
                'user_id' => null,
                'is_from_team' => true,
            ]);
        }

        // Messages for request 5 (Organic Cotton T-Shirts)
        $r5 = SourcingRequest::where('title', 'Organic Cotton T-Shirts (5000 units)')->first();
        if ($r5) {
            Message::firstOrCreate(['sourcing_request_id' => $r5->id, 'body' => 'Request submitted to GOTS-certified organic textile suppliers in Jiangsu and Shanghai.'], [
                'user_id' => null,
                'is_from_team' => true,
            ]);

            Message::firstOrCreate(['sourcing_request_id' => $r5->id, 'body' => 'Both suppliers provided excellent quotes. Jiangsu EcoTextiles has the premium quality option. Awaiting your decision.'], [
                'user_id' => null,
                'is_from_team' => true,
            ]);

            Message::firstOrCreate(['sourcing_request_id' => $r5->id, 'body' => 'Let\'s go with Jiangsu. The GOTS certification and custom printing service are exactly what we need.'], [
                'user_id' => $user->id,
                'is_from_team' => false,
            ]);
        }
    }
}
