<?php

use App\Models\SourcingRequest;
use Illuminate\Support\Facades\Broadcast;

// Buyer can subscribe to their own private channel
Broadcast::channel('user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

// Buyer or admin can subscribe to a sourcing request message channel
Broadcast::channel('sourcing-request.{requestId}', function ($user, $requestId) {
    $request = SourcingRequest::find($requestId);
    if (!$request) return false;
    return $user->is_admin || $request->user_id === $user->id;
});
