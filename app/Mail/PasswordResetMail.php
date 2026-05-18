<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user, public string $token)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Your Trivalo Sourcing Password',
        );
    }

    public function content(): Content
    {
        // Generate the password reset URL for the frontend
        // Frontend URL: /reset-password?token=xxx&email=xxx
        $resetUrl = config('app.url') . '/reset-password?token=' . $this->token . '&email=' . urlencode($this->user->email);

        return new Content(
            view: 'emails.password-reset',
            with: [
                'user' => $this->user,
                'resetUrl' => $resetUrl,
            ],
        );
    }
}
