<?php
namespace App\Http\Controllers;
use App\Models\SourcingRequest;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController {
    public function index(Request $request, SourcingRequest $sourcingRequest) {
        if ($sourcingRequest->user_id !== $request->user()->id) abort(403);
        return response()->json($sourcingRequest->messages()->with('user')->get());
    }

    public function store(Request $request, SourcingRequest $sourcingRequest) {
        if ($sourcingRequest->user_id !== $request->user()->id) abort(403);
        $data = $request->validate(['body' => ['required','string','max:5000']]);
        $msg = $sourcingRequest->messages()->create([
            'user_id'      => $request->user()->id,
            'is_from_team' => false,
            'body'         => $data['body'],
        ]);
        return response()->json($msg->load('user'), 201);
    }
}
