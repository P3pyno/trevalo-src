<?php
namespace App\Http\Controllers;
use App\Models\Document;
use App\Models\SourcingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController {
    public function index(Request $request) {
        $ids = $request->user()->sourcingRequests()->pluck('id');
        return response()->json(
            Document::whereIn('sourcing_request_id', $ids)
                ->with(['sourcingRequest:id,title','user:id,name'])
                ->latest()
                ->get()
        );
    }

    public function store(Request $request) {
        $data = $request->validate([
            'sourcing_request_id' => ['required','exists:sourcing_requests,id'],
            'name'                => ['nullable','string','max:255'],
            'type'                => ['required','string','max:100'],
            'file'                => ['required','file','max:102400','mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif,webp'],
        ]);

        $sr = SourcingRequest::find($data['sourcing_request_id']);
        if ($sr->user_id !== $request->user()->id) abort(403);

        $file = $request->file('file');
        $name = $data['name'] ?? $file->getClientOriginalName();
        $path = $file->storeAs('uploads/documents', Str::uuid().'.'.$file->extension(), 'public');

        $doc = Document::create([
            'user_id'             => $request->user()->id,
            'sourcing_request_id' => $data['sourcing_request_id'],
            'name'                => $name,
            'type'                => $data['type'],
            'file_path'           => $path,
            'size'                => $file->getSize(),
        ]);

        return response()->json($doc->load(['sourcingRequest:id,title','user:id,name']), 201);
    }

    public function destroy(Request $request, Document $document) {
        $ids = $request->user()->sourcingRequests()->pluck('id');
        if (!$ids->contains($document->sourcing_request_id)) abort(403);

        if ($document->file_path) Storage::disk('public')->delete($document->file_path);
        $document->delete();
        return response()->noContent();
    }
}
