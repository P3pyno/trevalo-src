<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class DashboardController {
    public function stats(Request $request) {
        $user = $request->user();
        $requests = $user->sourcingRequests();
        return response()->json([
            'active_requests'    => $requests->whereNotIn('status', ['delivered','cancelled'])->count(),
            'pending_quotes'     => \App\Models\Quote::whereIn('sourcing_request_id', $requests->pluck('id'))->where('status','pending')->count(),
            'shipments_in_transit' => \App\Models\Shipment::whereIn('sourcing_request_id', $requests->pluck('id'))->whereIn('status',['in_transit','customs'])->count(),
            'total_documents'    => \App\Models\Document::whereIn('sourcing_request_id', $requests->pluck('id'))->count(),
            'total_requests'     => $requests->count(),
        ]);
    }
}
