<?php
namespace App\Http\Controllers;
use App\Models\SourcingRequest;
use Illuminate\Http\Request;

class SourcingRequestController {
    public function index(Request $request) {
        return response()->json(
            $request->user()->sourcingRequests()->with(['quotes','shipments','documents'])->latest()->get()
        );
    }

    public function store(Request $request) {
        $data = $request->validate([
            'title'               => ['required','string','max:255'],
            'description'         => ['required','string'],
            'quantity'            => ['required','integer','min:1'],
            'target_price'        => ['nullable','numeric','min:0'],
            'currency'            => ['nullable','string','max:3'],
            'destination_country' => ['nullable','string','max:100'],
            'deadline'            => ['nullable','date','after:today'],
            'notes'               => ['nullable','string'],
        ]);
        $req = $request->user()->sourcingRequests()->create($data + ['status' => 'submitted']);
        return response()->json($req->load(['quotes','shipments','documents']), 201);
    }

    public function show(Request $request, SourcingRequest $sourcingRequest) {
        $this->authorize($request->user(), $sourcingRequest);
        return response()->json($sourcingRequest->load(['quotes','shipments','documents','messages.user']));
    }

    public function cancel(Request $request, SourcingRequest $sourcingRequest) {
        $this->authorize($request->user(), $sourcingRequest);
        $sourcingRequest->update(['status' => 'cancelled']);
        return response()->json(['message' => 'Request cancelled.']);
    }

    private function authorize($user, $req) {
        if ($req->user_id !== $user->id) abort(403);
    }
}
