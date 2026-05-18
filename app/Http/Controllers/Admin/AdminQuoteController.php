<?php

namespace App\Http\Controllers\Admin;

use App\Events\QuoteReceived;
use App\Models\Quote;
use App\Models\SourcingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminQuoteController
{
    public function index(Request $request)
    {
        $query = Quote::with(['sourcingRequest:id,title,user_id,status', 'sourcingRequest.user:id,name', 'supplier:id,supplier_code,name'])
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
            'supplier_id'         => ['required', 'exists:suppliers,id'],
            'moq'                 => ['required', 'integer', 'min:1'],
            'lead_time'           => ['required', 'string', 'max:100'],
            'notes'               => ['nullable', 'string'],
            'quote_file'          => ['nullable', 'file', 'mimes:xlsx,xls,pdf', 'max:10240'],
            'payment_method'      => ['nullable', 'string', 'in:tt,lc,dp,da'],
        ]);

        if ($request->hasFile('quote_file')) {
            $data['quote_file_path'] = $request->file('quote_file')->store('quotes', 'public');
        }
        unset($data['quote_file']);

        $quote = Quote::create($data);

        $sr = SourcingRequest::find($data['sourcing_request_id']);
        if (in_array($sr->status, ['submitted', 'in_progress'])) {
            $sr->update(['status' => 'quoted']);
        }

        $quote->load(['sourcingRequest:id,title,user_id', 'sourcingRequest.user:id,name', 'supplier:id,supplier_code,name']);
        broadcast(new QuoteReceived($quote));
        return response()->json($quote, 201);
    }

    public function update(Request $request, Quote $quote)
    {
        $data = $request->validate([
            'supplier_id'    => ['sometimes', 'exists:suppliers,id'],
            'moq'            => ['sometimes', 'integer', 'min:1'],
            'lead_time'      => ['sometimes', 'string', 'max:100'],
            'notes'          => ['nullable', 'string'],
            'quote_file'     => ['nullable', 'file', 'mimes:xlsx,xls,pdf', 'max:10240'],
            'payment_method' => ['nullable', 'string', 'in:tt,lc,dp,da'],
        ]);

        if ($request->hasFile('quote_file')) {
            if ($quote->quote_file_path) {
                Storage::disk('public')->delete($quote->quote_file_path);
            }
            $data['quote_file_path'] = $request->file('quote_file')->store('quotes', 'public');
        }
        unset($data['quote_file']);

        $quote->update($data);

        return response()->json($quote->load('supplier:id,supplier_code,name'));
    }

    public function destroy(Quote $quote)
    {
        if ($quote->quote_file_path) {
            Storage::disk('public')->delete($quote->quote_file_path);
        }
        $quote->delete();

        return response()->noContent();
    }
}
