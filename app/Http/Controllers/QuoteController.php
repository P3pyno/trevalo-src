<?php
namespace App\Http\Controllers;
use App\Models\Quote;
use App\Models\SourcingRequest;
use Illuminate\Http\Request;

class QuoteController {
    public function index(Request $request) {
        $ids = $request->user()->sourcingRequests()->pluck('id');
        return response()->json(Quote::whereIn('sourcing_request_id', $ids)->with('sourcingRequest')->latest()->get());
    }

    public function approve(Request $request, Quote $quote) {
        $this->authorize($request->user(), $quote);
        $quote->update(['status' => 'approved']);
        $quote->sourcingRequest->update(['status' => 'confirmed']);
        return response()->json(['message' => 'Quote approved.', 'quote' => $quote]);
    }

    public function reject(Request $request, Quote $quote) {
        $this->authorize($request->user(), $quote);
        $quote->update(['status' => 'rejected']);
        return response()->json(['message' => 'Quote rejected.', 'quote' => $quote]);
    }

    private function authorize($user, $quote) {
        if ($quote->sourcingRequest->user_id !== $user->id) abort(403);
    }
}
