<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Models\Shipment;
use App\Models\SourcingRequest;
use App\Models\User;

class AdminStatsController extends Controller
{
    public function index()
    {
        $requestsByStatus = SourcingRequest::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $recentRequests = SourcingRequest::with('user:id,name,email')
            ->latest()
            ->limit(5)
            ->get(['id', 'user_id', 'title', 'status', 'created_at']);

        return response()->json([
            'total_users'       => User::count(),
            'total_requests'    => SourcingRequest::count(),
            'open_requests'     => SourcingRequest::whereNotIn('status', ['delivered', 'cancelled'])->count(),
            'pending_quotes'    => Quote::where('status', 'pending')->count(),
            'active_shipments'  => Shipment::whereIn('status', ['in_transit', 'customs'])->count(),
            'requests_by_status' => $requestsByStatus,
            'recent_requests'   => $recentRequests,
        ]);
    }
}
