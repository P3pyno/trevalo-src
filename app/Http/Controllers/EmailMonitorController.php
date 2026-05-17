<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\User;

class EmailMonitorController extends Controller
{
    /**
     * Get recent email verification logs
     */
    public function logs()
    {
        // Read recent logs
        $logFile = storage_path('logs/laravel.log');
        
        if (!file_exists($logFile)) {
            return response()->json(['error' => 'Log file not found'], 404);
        }

        $logs = [];
        $lines = array_reverse(file($logFile));
        
        foreach ($lines as $line) {
            if (strpos($line, 'Email verification test') !== false || 
                strpos($line, 'email') !== false) {
                $logs[] = trim($line);
            }
            
            if (count($logs) >= 50) {
                break;
            }
        }

        return response()->json([
            'message' => 'Recent email logs',
            'count' => count($logs),
            'logs' => $logs
        ]);
    }

    /**
     * Get user email verification status
     */
    public function status($email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json([
            'user_id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'verified_at' => $user->email_verified_at,
            'is_verified' => $user->email_verified_at !== null,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at
        ]);
    }

    /**
     * Get all test users
     */
    public function testUsers()
    {
        $users = User::where('company', 'Test Company')
            ->orWhere('name', 'like', 'Test User%')
            ->get(['id', 'name', 'email', 'email_verified_at', 'created_at'])
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'verified' => $user->email_verified_at !== null,
                    'verified_at' => $user->email_verified_at,
                    'created_at' => $user->created_at
                ];
            });

        return response()->json([
            'message' => 'Test users',
            'count' => $users->count(),
            'users' => $users
        ]);
    }
}
