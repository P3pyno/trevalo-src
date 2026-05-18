<?php

namespace Tests\Feature;

use App\Models\SourcingRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthAndOwnershipTest extends TestCase
{
    use RefreshDatabase;

    public function test_unverified_user_cannot_log_in(): void
    {
        $user = User::factory()->unverified()->create([
            'password' => 'password',
        ]);

        $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ])
            ->assertStatus(403)
            ->assertJsonPath('needs_verification', true)
            ->assertJsonPath('email', $user->email);
    }

    public function test_signed_verification_link_marks_email_as_verified(): void
    {
        $user = User::factory()->unverified()->create();

        $url = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(30),
            ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())],
        );

        $this->getJson($url)
            ->assertOk()
            ->assertJsonPath('verified', true);

        $this->assertNotNull($user->fresh()->email_verified_at);
    }

    public function test_verification_link_requires_a_valid_signature(): void
    {
        $user = User::factory()->unverified()->create();

        $this->getJson("/api/auth/verify-email/{$user->id}/".sha1($user->getEmailForVerification()))
            ->assertForbidden();
    }

    public function test_sourcing_request_search_does_not_leak_other_users_records(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $ownedRequest = SourcingRequest::create([
            'user_id' => $user->id,
            'title' => 'Needle Widget',
            'description' => 'Owned by the signed in user.',
            'quantity' => 10,
            'currency' => 'USD',
            'status' => 'submitted',
        ]);

        $otherRequest = SourcingRequest::create([
            'user_id' => $otherUser->id,
            'title' => 'Other Widget',
            'description' => 'Contains needle in another account.',
            'quantity' => 20,
            'currency' => 'USD',
            'status' => 'submitted',
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/sourcing-requests?search=needle');

        $response->assertOk();
        $this->assertSame([$ownedRequest->id], collect($response->json('data'))->pluck('id')->all());
        $this->assertNotContains($otherRequest->id, collect($response->json('data'))->pluck('id')->all());
    }

    public function test_quote_search_does_not_leak_other_users_records(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $ownedRequest = SourcingRequest::create([
            'user_id' => $user->id,
            'title' => 'Owned Request',
            'description' => 'Owned request description.',
            'quantity' => 5,
            'currency' => 'USD',
            'status' => 'submitted',
        ]);

        $otherRequest = SourcingRequest::create([
            'user_id' => $otherUser->id,
            'title' => 'Other Request',
            'description' => 'Other request description.',
            'quantity' => 8,
            'currency' => 'USD',
            'status' => 'submitted',
        ]);

        DB::table('quotes')->insert([
            [
                'sourcing_request_id' => $ownedRequest->id,
                'supplier_name' => 'Needle Supplier',
                'moq' => 10,
                'lead_time' => '7 days',
                'quote_file_path' => 'uploads/quotes/owned.pdf',
                'payment_method' => 'Bank transfer',
                'notes' => 'Owned quote note.',
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sourcing_request_id' => $otherRequest->id,
                'supplier_name' => 'Other Supplier',
                'moq' => 12,
                'lead_time' => '10 days',
                'quote_file_path' => 'uploads/quotes/other.pdf',
                'payment_method' => 'Bank transfer',
                'notes' => 'Contains needle in another account.',
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/quotes?search=needle');

        $response->assertOk();
        $this->assertSame([$ownedRequest->id], collect($response->json('data'))->pluck('sourcing_request_id')->all());
        $this->assertNotContains($otherRequest->id, collect($response->json('data'))->pluck('sourcing_request_id')->all());
    }
}
