<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::withCount('sourcingRequests')
            ->withCount(['sourcingRequests as open_requests_count' => fn($q) =>
                $q->whereNotIn('status', ['delivered', 'cancelled'])
            ])
            ->latest()
            ->paginate(20);

        return response()->json($users);
    }

    public function show(User $user)
    {
        $user->loadCount('sourcingRequests');
        $user->load(['sourcingRequests' => fn($q) =>
            $q->latest()->limit(10)->withCount(['quotes', 'shipments'])
        ]);

        return response()->json($user);
    }
}
