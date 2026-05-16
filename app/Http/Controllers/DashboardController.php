<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Carbon\Carbon;

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
    
    public function analytics(Request $request) {
        $user = $request->user();
        $requestIds = $user->sourcingRequests()->pluck('id');
        
        $quotes = \App\Models\Quote::whereIn('sourcing_request_id', $requestIds);
        $shipments = \App\Models\Shipment::whereIn('sourcing_request_id', $requestIds);
        
        // Quote metrics
        $totalQuotes = $quotes->count();
        $approvedQuotes = $quotes->where('status', 'approved')->count();
        $conversionRate = $totalQuotes > 0 ? round(($approvedQuotes / $totalQuotes) * 100, 2) : 0;
        
        // Price metrics
        $avgQuotePrice = $quotes->avg('total_price') ?? 0;
        $minQuotePrice = $quotes->min('total_price') ?? 0;
        $maxQuotePrice = $quotes->max('total_price') ?? 0;
        
        // Time metrics - average days to quote
        // SQLite doesn't support DATEDIFF, use julianday instead
        $avgDaysToQuote = \DB::table('quotes')
            ->whereIn('sourcing_request_id', $requestIds)
            ->selectRaw('AVG(julianday(quotes.created_at) - julianday((SELECT created_at FROM sourcing_requests WHERE id = quotes.sourcing_request_id))) as avg_days')
            ->value('avg_days') ?? 0;
        
        // Status breakdown
        $requestStatuses = \App\Models\SourcingRequest::whereIn('id', $requestIds)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');
        
        return response()->json([
            'quote_metrics' => [
                'total' => $totalQuotes,
                'approved' => $approvedQuotes,
                'rejected' => $quotes->where('status', 'rejected')->count(),
                'pending' => $quotes->where('status', 'pending')->count(),
                'conversion_rate' => $conversionRate,
            ],
            'price_metrics' => [
                'average' => round($avgQuotePrice, 2),
                'minimum' => round($minQuotePrice, 2),
                'maximum' => round($maxQuotePrice, 2),
            ],
            'time_metrics' => [
                'avg_days_to_quote' => round($avgDaysToQuote, 2),
            ],
            'request_statuses' => $requestStatuses,
            'shipment_count' => $shipments->count(),
        ]);
    }
    
    public function supplierPerformance(Request $request) {
        $user = $request->user();
        $requestIds = $user->sourcingRequests()->pluck('id');
        
        $suppliers = \App\Models\Quote::whereIn('sourcing_request_id', $requestIds)
            ->selectRaw('supplier_name, 
                        COUNT(*) as quote_count,
                        SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) as approved_count,
                        AVG(total_price) as avg_price,
                        MIN(created_at) as first_quote_date')
            ->groupBy('supplier_name')
            ->orderByDesc('quote_count')
            ->limit(20)
            ->get()
            ->map(function($s) {
                return [
                    'supplier_name' => $s->supplier_name,
                    'quote_count' => $s->quote_count,
                    'approved_count' => $s->approved_count,
                    'approval_rate' => $s->quote_count > 0 ? round(($s->approved_count / $s->quote_count) * 100, 2) : 0,
                    'avg_price' => round($s->avg_price, 2),
                    'first_quote_date' => $s->first_quote_date,
                ];
            });
        
        return response()->json($suppliers);
    }
    
    public function activityLogs(Request $request) {
        $perPage = $request->query('per_page', 20);
        
        $logs = ActivityLog::where('user_id', $request->user()->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
        
        return response()->json($logs);
    }
}
