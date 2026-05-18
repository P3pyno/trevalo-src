<?php
namespace App\Http\Controllers;
use App\Models\Shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller {
    public function index(Request $request) {
        $ids = $request->user()->sourcingRequests()->pluck('id');
        return response()->json(Shipment::whereIn('sourcing_request_id', $ids)->with('sourcingRequest')->latest()->get());
    }
}
