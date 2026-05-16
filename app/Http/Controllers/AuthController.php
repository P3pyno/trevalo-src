<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\EmailVerificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class AuthController
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => ['required', 'email', 'max:255', 'unique:users'],
            'company'    => ['nullable', 'string', 'max:255'],
            'password'   => ['required', 'string', Password::min(8)],
        ]);

        $user = User::create([
            'name'     => $data['first_name'] . ' ' . $data['last_name'],
            'email'    => $data['email'],
            'company'  => $data['company'] ?? null,
            'password' => Hash::make($data['password']),
        ]);

        // Send verification email
        Mail::send(new EmailVerificationMail($user));

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

        return response()->json([
            'message' => 'Email verified successfully. You can now log in.',
            'verified' => true,
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

        Mail::send(new EmailVerificationMail($user));

        return response()->json(['message' => 'Verification email sent. Please check your inbox.']);
    }
}
