<?php
namespace App\Http\Controllers;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController {
    public function index(Request $request) {
        $ids = $request->user()->sourcingRequests()->pluck('id');
        return response()->json(Document::whereIn('sourcing_request_id', $ids)->with('sourcingRequest')->latest()->get());
    }
}
