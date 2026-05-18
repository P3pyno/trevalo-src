<?php
namespace App\Http\Controllers\Admin;
use App\Events\MessageSent;
use App\Models\SourcingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminMessageController {
    public function threads() {
        return response()->json(
            SourcingRequest::has('messages')
                ->with([
                    'user:id,name,email',
                    'messages' => fn($q) => $q->latest()->limit(1),
                    'messages.user:id,name',
                ])
                ->latest('updated_at')
                ->get(['id','user_id','title','status','updated_at'])
        );
    }

    public function index(SourcingRequest $sourcingRequest) {
        return response()->json(
            $sourcingRequest->messages()->with('user:id,name')->oldest()->get()
        );
    }

    public function store(Request $request, SourcingRequest $sourcingRequest) {
        $data = $request->validate([
            'body'       => ['nullable','string','max:5000'],
            'attachment' => ['nullable','file','max:20480'],
        ]);

        if (empty($data['body']) && !$request->hasFile('attachment')) {
            return response()->json(['message' => 'Message body or attachment required.'], 422);
        }

        $payload = [
            'user_id'      => $request->user()->id,
            'is_from_team' => true,
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
        $msg->load('user:id,name');
        broadcast(new MessageSent($msg))->toOthers();
        return response()->json($msg, 201);
    }
}
