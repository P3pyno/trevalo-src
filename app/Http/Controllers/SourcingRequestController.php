<?php
namespace App\Http\Controllers;
use App\Events\NewSourcingRequest;
use App\Models\SourcingRequest;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SourcingRequestController {
    public function index(Request $request) {
        $query = $request->user()->sourcingRequests()->with(['quotes','shipments','documents']);
        
        // Pagination
        $perPage = $request->query('per_page', 15);
        
        // Search
        if ($search = $request->query('search')) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Filters
        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }
        
        if ($currency = $request->query('currency')) {
            $query->where('currency', $currency);
        }
        
        if ($minPrice = $request->query('min_price')) {
            $query->where('target_price', '>=', $minPrice);
        }
        
        if ($maxPrice = $request->query('max_price')) {
            $query->where('target_price', '<=', $maxPrice);
        }
        
        if ($sortBy = $request->query('sort_by')) {
            $direction = $request->query('sort_dir', 'desc');
            $query->orderBy($sortBy, $direction);
        } else {
            $query->latest();
        }
        
        return response()->json($query->paginate($perPage));
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
            'images'              => ['nullable','array','max:10'],
            'images.*'            => ['image','max:5120'],
        ]);

        $imagePaths = [];
        foreach ($request->file('images', []) as $img) {
            $path = $img->storeAs('uploads/products', Str::uuid().'.'.$img->extension(), 'public');
            $imagePaths[] = $path;
        }

        unset($data['images']);
        if ($imagePaths) $data['product_images'] = $imagePaths;

        $req = $request->user()->sourcingRequests()->create($data + ['status' => 'submitted']);
        $req->load(['quotes','shipments','documents']);
        broadcast(new NewSourcingRequest($req));
        return response()->json($req, 201);
    }

    public function show(Request $request, SourcingRequest $sourcingRequest) {
        $this->gate($request->user(), $sourcingRequest);
        return response()->json($sourcingRequest->load(['quotes','shipments','documents','messages.user']));
    }

    public function cancel(Request $request, SourcingRequest $sourcingRequest) {
        $this->gate($request->user(), $sourcingRequest);
        $sourcingRequest->update(['status' => 'cancelled']);
        ActivityLog::log('updated', 'SourcingRequest', $sourcingRequest->id, "{$sourcingRequest->title} cancelled", ['status' => 'cancelled']);
        return response()->json(['message' => 'Request cancelled.']);
    }

    private function gate($user, $req) {
        if ($req->user_id !== $user->id) abort(403);
    }
}
