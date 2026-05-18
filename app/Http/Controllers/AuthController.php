<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\EmailVerificationMail;
use App\Mail\PasswordResetMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        if (!$request->filled('email') && $request->filled('work_email')) {
            $request->merge(['email' => $request->input('work_email')]);
        }

        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => ['required', 'email', 'max:255', 'unique:users'],
            'company'    => ['nullable', 'string', 'max:255'],
            'password'   => ['required', 'string', PasswordRule::min(8)],
        ]);

        $user = User::create([
            'name'     => $data['first_name'] . ' ' . $data['last_name'],
            'email'    => $data['email'],
            'company'  => $data['company'] ?? null,
            'password' => Hash::make($data['password']),
        ]);

        // Send verification email
        Mail::to($user->email)->send(new EmailVerificationMail($user));

        return response()->json([
            'message' => 'Registration successful. Please check your email to verify your account.',
            'user'    => $user->profileFields(),
        ], 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            return response()->json(['message' => 'Invalid email or password.'], 401);
        }

        $user = Auth::user();

        // Check if email is verified
        if (!$user->hasVerifiedEmail()) {
            Auth::logout();
            return response()->json([
                'message'    => 'Please verify your email address before logging in.',
                'needs_verification' => true,
                'email'      => $user->email,
            ], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user'  => $user->profileFields(),
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out.']);
    }

    public function me(Request $request)
    {
        return response()->json($request->user()->profileFields());
    }

    public function verifyEmail(Request $request, $id, $hash)
    {
        if (!$request->hasValidSignature(false)) {
            return response()->json(['message' => 'Invalid or expired verification link.'], 403);
        }

        $user = User::findOrFail($id);

        // Verify the hash matches
        if (sha1($user->getEmailForVerification()) !== $hash) {
            return response()->json(['message' => 'Invalid verification link.'], 400);
        }

        // Check if already verified
        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified.'], 200);
        }

        // Mark email as verified
        $user->markEmailAsVerified();

        // Auto-login so the frontend can redirect straight to onboarding
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'  => 'Email verified successfully.',
            'verified' => true,
            'user'     => $user->profileFields(),
            'token'    => $token,
        ]);
    }

    public function resendVerificationEmail(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'exists:users'],
        ]);

        $user = User::where('email', $data['email'])->firstOrFail();

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified.'], 400);
        }

        Mail::to($user->email)->send(new EmailVerificationMail($user));

        return response()->json(['message' => 'Verification email sent. Please check your inbox.']);
    }

    public function completeOnboarding(Request $request)
    {
        $data = $request->validate([
            'company' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:100'],
            'phone'   => ['nullable', 'string', 'max:50'],
        ]);

        $request->user()->update(array_merge($data, ['onboarding_completed' => true]));

        return response()->json(['user' => $request->user()->fresh()->profileFields()]);
    }

    public function forgotPassword(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        $user = User::where('email', $data['email'])->firstOrFail();

        // Generate a password reset token
        $token = Str::random(64);

        // Store the token in the password_reset_tokens table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        // Send password reset email
        Mail::to($user->email)->send(new PasswordResetMail($user, $token));

        return response()->json([
            'message' => 'Password reset link sent to your email. Please check your inbox.',
        ]);
    }

    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'email'                 => ['required', 'email', 'exists:users,email'],
            'token'                 => ['required', 'string'],
            'password'              => ['required', 'string', PasswordRule::min(8)],
            'password_confirmation' => ['required', 'string', 'same:password'],
        ]);

        // Get the stored token
        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $data['email'])
            ->first();

        if (!$resetRecord) {
            return response()->json(['message' => 'Invalid or expired password reset link.'], 400);
        }

        // Check if token matches
        if (!Hash::check($data['token'], $resetRecord->token)) {
            return response()->json(['message' => 'Invalid password reset token.'], 400);
        }

        // Check if token is not expired (1 hour)
        if (now()->diffInHours($resetRecord->created_at) > 1) {
            // Delete the expired token
            DB::table('password_reset_tokens')->where('email', $data['email'])->delete();
            return response()->json(['message' => 'Password reset link has expired.'], 400);
        }

        // Update the user's password
        $user = User::where('email', $data['email'])->firstOrFail();
        $user->update(['password' => Hash::make($data['password'])]);

        // Delete the token
        DB::table('password_reset_tokens')->where('email', $data['email'])->delete();

        return response()->json([
            'message' => 'Password has been reset successfully. You can now log in with your new password.',
        ]);
    }
}
