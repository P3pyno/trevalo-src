<?php

namespace App\Http\Controllers\Admin;

use App\Models\Quote;
use App\Models\SourcingRequest;
use Illuminate\Http\Request;

class AdminQuoteController
{
    public function index(Request $request)
    {
        $query = Quote::with(['sourcingRequest:id,title,user_id,status', 'sourcingRequest.user:id,name'])
            ->latest();

        if ($request->sourcing_request_id) {
            $query->where('sourcing_request_id', $request->sourcing_request_id);
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sourcing_request_id' => ['required', 'exists:sourcing_requests,id'],
            'supplier_name'       => ['required', 'string', 'max:255'],
            'unit_price'          => ['required', 'numeric', 'min:0'],
            'total_price'         => ['required', 'numeric', 'min:0'],
            'currency'            => ['required', 'string', 'size:3'],
            'moq'                 => ['required', 'integer', 'min:1'],
            'lead_time'           => ['required', 'string', 'max:100'],
            'notes'               => ['nullable', 'string'],
        ]);

        $quote = Quote::create($data);

        $sr = SourcingRequest::find($data['sourcing_request_id']);
        if (in_array($sr->status, ['submitted', 'in_progress'])) {
            $sr->update(['status' => 'quoted']);
        }

        $quote->load(['sourcingRequest:id,title,user_id', 'sourcingRequest.user:id,name']);

        return response()->json($quote, 201);
    }

    public function update(Request $request, Quote $quote)
    {
        $data = $request->validate([
            'supplier_name' => ['sometimes', 'string', 'max:255'],
            'unit_price'    => ['sometimes', 'numeric', 'min:0'],
            'total_price'   => ['sometimes', 'numeric', 'min:0'],
            'currency'      => ['sometimes', 'string', 'size:3'],
            'moq'           => ['sometimes', 'integer', 'min:1'],
            'lead_time'     => ['sometimes', 'string', 'max:100'],
            'notes'         => ['nullable', 'string'],
        ]);

        $quote->update($data);

        return response()->json($quote);
    }

    public function destroy(Quote $quote)
    {
        $quote->delete();

        return response()->noContent();
    }
}
