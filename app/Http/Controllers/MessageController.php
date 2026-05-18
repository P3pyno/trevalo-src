<?php
namespace App\Http\Controllers;
use App\Events\MessageSent;
use App\Models\SourcingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MessageController {
    public function index(Request $request, SourcingRequest $sourcingRequest) {
        if ($sourcingRequest->user_id !== $request->user()->id) abort(403);
        return response()->json($sourcingRequest->messages()->with('user')->get());
    }

    public function store(Request $request, SourcingRequest $sourcingRequest) {
        if ($sourcingRequest->user_id !== $request->user()->id) abort(403);

        $data = $request->validate([
            'body'       => ['nullable','string','max:5000'],
            'attachment' => ['nullable','file','max:20480'],
        ]);

        if (empty($data['body']) && !$request->hasFile('attachment')) {
            return response()->json(['message' => 'Message body or attachment required.'], 422);
        }

        $payload = [
            'user_id'      => $request->user()->id,
            'is_from_team' => false,
            'body'         => $data['body'] ?? '',
        ];

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->storeAs('uploads/messages', Str::uuid().'.'.$file->extension(), 'public');
            $payload['attachment_path'] = $path;
            $payload['attachment_name'] = $file->getClientOriginalName();
            $payload['attachment_mime'] = $file->getMimeType();
        }

        $msg = $sourcingRequest->messages()->create($payload);
        $msg->load('user');
        broadcast(new MessageSent($msg))->toOthers();
        return response()->json($msg, 201);
    }
}
