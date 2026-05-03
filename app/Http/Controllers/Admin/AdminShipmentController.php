<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shipment;
use Illuminate\Http\Request;

class AdminShipmentController
{
    public function index(Request $request)
    {
        $query = Shipment::with(['sourcingRequest:id,title,user_id', 'sourcingRequest.user:id,name'])
            ->latest();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sourcing_request_id' => ['required', 'exists:sourcing_requests,id'],
            'tracking_number'     => ['nullable', 'string', 'max:100'],
            'carrier'             => ['nullable', 'string', 'max:100'],
            'origin'              => ['nullable', 'string', 'max:255'],
            'destination'         => ['required', 'string', 'max:255'],
            'method'              => ['required', 'in:sea,air,express'],
            'status'              => ['nullable', 'in:pending,in_transit,customs,delivered'],
            'estimated_arrival'   => ['nullable', 'date'],
        ]);

        $data['origin'] = $data['origin'] ?? 'Guangzhou, China';

        $shipment = Shipment::create($data);
        $shipment->load(['sourcingRequest:id,title,user_id', 'sourcingRequest.user:id,name']);

        return response()->json($shipment, 201);
    }

    public function update(Request $request, Shipment $shipment)
    {
        $data = $request->validate([
            'tracking_number'   => ['nullable', 'string', 'max:100'],
            'carrier'           => ['nullable', 'string', 'max:100'],
            'origin'            => ['nullable', 'string', 'max:255'],
            'destination'       => ['sometimes', 'string', 'max:255'],
            'method'            => ['sometimes', 'in:sea,air,express'],
            'status'            => ['sometimes', 'in:pending,in_transit,customs,delivered'],
            'estimated_arrival' => ['nullable', 'date'],
        ]);

        $shipment->update($data);

        return response()->json($shipment);
    }
}
