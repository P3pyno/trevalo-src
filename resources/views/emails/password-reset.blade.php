<p>Hi {{ $user->name }},</p>

<p>You requested to reset your password for your Trivalo Sourcing account. Click the link below to set a new password:</p>

<p style="text-align: center; margin: 30px 0;">
  <a href="{{ $resetUrl }}" style="background-color: #C8A45D; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: bold; display: inline-block;">
    Reset Password
  </a>
</p>

<p>Or copy this link: <a href="{{ $resetUrl }}">{{ $resetUrl }}</a></p>

<p style="color: #666; font-size: 14px;">This link will expire in 1 hour.</p>

<p style="color: #999; font-size: 12px; margin-top: 20px;">
  If you didn't request a password reset, please ignore this email. Your password will remain unchanged.
</p>
