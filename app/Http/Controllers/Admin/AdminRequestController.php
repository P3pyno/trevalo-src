<?php

namespace App\Http\Controllers\Admin;

use App\Models\SourcingRequest;
use Illuminate\Http\Request;

class AdminRequestController
{
    private const VALID_STATUSES = [
        'submitted', 'in_progress', 'quoted', 'confirmed',
        'production', 'shipped', 'delivered', 'cancelled',
    ];

    public function index(Request $request)
    {
        $query = SourcingRequest::with('user:id,name,email')
            ->withCount(['quotes', 'shipments'])
            ->latest();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        return response()->json($query->get());
    }

    public function show(SourcingRequest $sourcingRequest)
    {
        $sourcingRequest->load([
            'user:id,name,email,company',
            'quotes',
            'shipments',
            'documents',
            'messages.user:id,name',
        ]);

        return response()->json($sourcingRequest);
    }

    public function updateStatus(Request $request, SourcingRequest $sourcingRequest)
    {
        $data = $request->validate([
            'status' => ['required', 'string', 'in:' . implode(',', self::VALID_STATUSES)],
        ]);

        $sourcingRequest->update($data);

        return response()->json($sourcingRequest);
    }
}
