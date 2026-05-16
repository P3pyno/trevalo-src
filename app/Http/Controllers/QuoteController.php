<?php
namespace App\Http\Controllers;
use App\Models\Quote;
use App\Models\SourcingRequest;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class QuoteController {
    public function index(Request $request) {
        $ids = $request->user()->sourcingRequests()->pluck('id');
        
        $query = Quote::whereIn('sourcing_request_id', $ids)->with('sourcingRequest');
        
        // Pagination
        $perPage = $request->query('per_page', 15);
        
        // Search
        if ($search = $request->query('search')) {
            $query->where('supplier_name', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%");
        }
        
        // Filters
        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }
        
        if ($minPrice = $request->query('min_price')) {
            $query->where('total_price', '>=', $minPrice);
        }
        
        if ($maxPrice = $request->query('max_price')) {
            $query->where('total_price', '<=', $maxPrice);
        }
        
        if ($sortBy = $request->query('sort_by')) {
            $direction = $request->query('sort_dir', 'desc');
            $query->orderBy($sortBy, $direction);
        } else {
            $query->latest();
        }
        
        return response()->json($query->paginate($perPage));
    }

    public function approve(Request $request, Quote $quote) {
        $this->authorize($request->user(), $quote);
        $quote->update(['status' => 'approved']);
        $quote->sourcingRequest->update(['status' => 'confirmed']);
        ActivityLog::log('updated', 'Quote', $quote->id, "Quote from {$quote->supplier_name} approved", ['status' => 'approved']);
        return response()->json(['message' => 'Quote approved.', 'quote' => $quote]);
    }

    public function reject(Request $request, Quote $quote) {
        $this->authorize($request->user(), $quote);
        $quote->update(['status' => 'rejected']);
        ActivityLog::log('updated', 'Quote', $quote->id, "Quote from {$quote->supplier_name} rejected", ['status' => 'rejected']);
        return response()->json(['message' => 'Quote rejected.', 'quote' => $quote]);
    }
    
    public function bulkApprove(Request $request) {
        $quoteIds = $request->validate(['ids' => 'required|array'])['ids'];
        $ids = $request->user()->sourcingRequests()->pluck('id');
        
        $quotes = Quote::whereIn('id', $quoteIds)->whereIn('sourcing_request_id', $ids)->get();
        
        foreach ($quotes as $quote) {
            $quote->update(['status' => 'approved']);
            $quote->sourcingRequest->update(['status' => 'confirmed']);
            ActivityLog::log('updated', 'Quote', $quote->id, "Quote bulk approved", ['status' => 'approved']);
        }
        
        return response()->json(['message' => "Approved {$quotes->count()} quotes.", 'count' => $quotes->count()]);
    }
    
    public function bulkReject(Request $request) {
        $quoteIds = $request->validate(['ids' => 'required|array'])['ids'];
        $ids = $request->user()->sourcingRequests()->pluck('id');
        
        $quotes = Quote::whereIn('id', $quoteIds)->whereIn('sourcing_request_id', $ids)->get();
        
        foreach ($quotes as $quote) {
            $quote->update(['status' => 'rejected']);
            ActivityLog::log('updated', 'Quote', $quote->id, "Quote bulk rejected", ['status' => 'rejected']);
        }
        
        return response()->json(['message' => "Rejected {$quotes->count()} quotes.", 'count' => $quotes->count()]);
    }

    private function authorize($user, $quote) {
        if ($quote->sourcingRequest->user_id !== $user->id) abort(403);
    }
}
