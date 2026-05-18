<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class EmailVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify Your Email Address — Trivalo Sourcing',
        );
    }

    public function content(): Content
    {
        $signedVerificationPath = URL::temporarySignedRoute(
            'verification.verify',
            now()->addHours(24),
            ['id' => $this->user->getKey(), 'hash' => sha1($this->user->getEmailForVerification())],
            absolute: false,
        );

        $signedPath = parse_url($signedVerificationPath, PHP_URL_PATH) ?: '';
        $signedQuery = parse_url($signedVerificationPath, PHP_URL_QUERY) ?: '';
        $frontendBaseUrl = rtrim((string) env('FRONTEND_URL', config('app.url')), '/');
        $frontendPath = preg_replace('#^/api/auth/verify-email/#', '/verify-email/', $signedPath) ?: $signedPath;
        $verificationUrl = $frontendBaseUrl.$frontendPath.($signedQuery !== '' ? '?'.$signedQuery : '');

        return new Content(
            view: 'emails.verify-email',
            with: [
                'user' => $this->user,
                'verificationUrl' => $verificationUrl,
            ],
        );
    }
}
