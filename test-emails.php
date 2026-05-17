<?php
/**
 * Email Testing Script for Trivalo Sourcing
 * 
 * Usage: php test-emails.php [email]
 * Example: php test-emails.php test1@example.com
 */

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Mail\EmailVerificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

echo "\n";
echo "═══════════════════════════════════════════════════════\n";
echo "  Trivalo Sourcing - Email Verification Testing\n";
echo "═══════════════════════════════════════════════════════\n";
echo "\n";

$testEmails = [
    'test1@example.com',
    'test2@example.com',
    'demo@trivalo.com',
    'salhI45adam@gmail.com'
];

if ($argc > 1) {
    $testEmails = array_slice($argv, 1);
}

foreach ($testEmails as $email) {
    echo "Testing email: $email\n";
    echo "─────────────────────────────────────────────────────\n";
    
    try {
        // Check if user exists
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            echo "  ✓ Creating user: $email\n";
            $user = User::create([
                'name' => 'Test User ' . uniqid(),
                'email' => $email,
                'password' => bcrypt('TestPassword123'),
                'company' => 'Test Company',
                'email_verified_at' => null
            ]);
            echo "    User ID: {$user->id}\n";
        } else {
            echo "  ✓ User exists: {$user->name} (ID: {$user->id})\n";
            // Reset verification for testing
            $user->email_verified_at = null;
            $user->save();
            echo "    Email verification reset\n";
        }
        
        // Send verification email
        echo "  ✓ Sending verification email...\n";
        $startTime = microtime(true);
        
        Mail::to($user->email)->send(new EmailVerificationMail($user));
        
        $duration = round((microtime(true) - $startTime) * 1000, 2);
        echo "    ✓ Email sent successfully ({$duration}ms)\n";
        
        // Generate verification URL
        $verificationUrl = \Illuminate\Support\Facades\URL::signedRoute(
            'verification.verify',
            [
                'id' => $user->id,
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );
        
        echo "  ✓ Verification URL:\n";
        echo "    $verificationUrl\n";
        
        // Log entry
        Log::info("Email test sent to $email", [
            'user_id' => $user->id,
            'email' => $email,
            'duration_ms' => $duration,
            'verified_at' => $user->email_verified_at
        ]);
        
    } catch (\Exception $e) {
        echo "  ✗ Error: {$e->getMessage()}\n";
        Log::error("Email test failed for $email", [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
    
    echo "\n";
}

echo "═══════════════════════════════════════════════════════\n";
echo "  Testing complete! Check logs in storage/logs/laravel.log\n";
echo "═══════════════════════════════════════════════════════\n\n";
