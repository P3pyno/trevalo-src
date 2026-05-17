<?php

namespace App\Console\Commands;

use App\Mail\EmailVerificationMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TestEmailVerification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email {email} {--reset} {--mailer=smtp : Mailer to use (smtp, log, or array)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email verification with different email addresses';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $reset = $this->option('reset');
        $mailer = $this->option('mailer');

        // Override mailer if specified
        if ($mailer && $mailer !== 'smtp') {
            config(['mail.default' => $mailer]);
        }

        $this->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->info("Email Verification Test: $email");
        $this->info("Mailer: " . config('mail.default'));
        $this->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");

        try {
            // Find or create user
            $user = User::where('email', $email)->first();

            if (!$user) {
                $this->info("Creating user...");
                $user = User::create([
                    'name' => 'Test User ' . uniqid(),
                    'email' => $email,
                    'password' => bcrypt('TestPassword123'),
                    'company' => 'Test Company',
                    'email_verified_at' => null,
                ]);
                $this->line("<info>✓</info> User created (ID: {$user->id})");
            } else {
                $this->line("<info>✓</info> User exists: {$user->name} (ID: {$user->id})");
            }

            // Reset verification if requested
            if ($reset) {
                $user->email_verified_at = null;
                $user->save();
                $this->line("<info>✓</info> Email verification reset");
            }

            // Check current verification status
            if ($user->email_verified_at) {
                $this->line("<comment>ℹ</comment> User already verified at: {$user->email_verified_at}");
            } else {
                $this->line("<comment>ℹ</comment> User email not yet verified");
            }

            // Send verification email
            $this->info("\nSending verification email...");
            $startTime = microtime(true);

            Mail::to($user->email)->send(new EmailVerificationMail($user));

            $duration = round((microtime(true) - $startTime) * 1000, 2);
            $this->line("<info>✓</info> Email sent successfully ({$duration}ms)");

            // Generate verification URL
            $verificationUrl = \Illuminate\Support\Facades\URL::signedRoute(
                'verification.verify',
                [
                    'id' => $user->id,
                    'hash' => sha1($user->getEmailForVerification()),
                ]
            );

            $this->info("\nVerification URL:");
            $this->line("<comment>$verificationUrl</comment>");

            // Copy to clipboard note
            $this->line("\n<comment>Tip:</comment> Click the URL above to verify the email");
            $this->line("     Or use the verify-email route with the provided ID and hash");

            // Log the test
            Log::info('Email verification test', [
                'email' => $email,
                'user_id' => $user->id,
                'duration_ms' => $duration,
                'reset' => $reset,
            ]);

            $this->info("\n✓ Test completed successfully!");

        } catch (\Exception $e) {
            $this->error("✗ Error: {$e->getMessage()}");
            Log::error('Email verification test failed', [
                'email' => $email,
                'error' => $e->getMessage(),
            ]);

            return 1;
        }

        $this->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n");

        return 0;
    }
}
