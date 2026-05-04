<?php
namespace App\Http\Controllers\Admin;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminDocumentController {
    public function index() {
        return response()->json(
            Document::with(['sourcingRequest:id,title,user_id','sourcingRequest.user:id,name','user:id,name'])
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

        $file = $request->file('file');
        $name = $data['name'] ?: $file->getClientOriginalName();
        $path = $file->storeAs('uploads/documents', Str::uuid().'.'.$file->extension(), 'public');
        $url  = Storage::disk('public')->url($path);

        $doc = Document::create([
            'user_id'             => $request->user()->id,
            'sourcing_request_id' => $data['sourcing_request_id'],
            'name'                => $name,
            'type'                => $data['type'],
            'file_path'           => $path,
            'url'                 => $url,
            'size'                => $file->getSize(),
        ]);

        return response()->json($doc->load(['sourcingRequest:id,title','user:id,name']), 201);
    }

    public function destroy(Document $document) {
        if ($document->file_path) Storage::disk('public')->delete($document->file_path);
        $document->delete();
        return response()->noContent();
    }
}
