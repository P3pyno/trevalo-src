<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f5f5; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); overflow: hidden; }
        .header { background: linear-gradient(135deg, #1e293b 0%, #334155 100%); color: white; padding: 40px 20px; text-align: center; }
        .header h1 { margin: 0; font-size: 28px; }
        .content { padding: 40px 30px; }
        .content p { color: #475569; line-height: 1.6; margin: 15px 0; }
        .button { display: inline-block; padding: 14px 32px; background-color: #d97706; color: white; text-decoration: none; border-radius: 6px; font-weight: 600; margin: 30px 0; }
        .button:hover { background-color: #b45309; }
        .footer { background-color: #f8fafc; padding: 20px 30px; text-align: center; color: #64748b; font-size: 12px; border-top: 1px solid #e2e8f0; }
        .expires { color: #f97316; font-weight: 500; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Email Verification Required</h1>
            <p>Welcome to Trivalo Sourcing!</p>
        </div>
        
        <div class="content">
            <p>Hi {{ $user->name }},</p>
            
            <p>Thank you for registering with Trivalo Sourcing. To complete your registration and access your account, please verify your email address by clicking the button below.</p>
            
            <center>
                <a href="{{ $verificationUrl }}" class="button">Verify Email Address</a>
            </center>
            
            <p>This verification link will expire in <span class="expires">24 hours</span>.</p>
            
            <p>If you didn't create this account, please ignore this email.</p>
            
            <p style="color: #94a3b8; font-size: 13px;">
                <strong>Or copy this link in your browser:</strong><br>
                {{ $verificationUrl }}
            </p>
        </div>
        
        <div class="footer">
            <p style="margin: 0;">
                <strong>Trivalo Sourcing</strong> — Your Global Sourcing Partner<br>
                © {{ date('Y') }} Trivalo Sourcing. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
