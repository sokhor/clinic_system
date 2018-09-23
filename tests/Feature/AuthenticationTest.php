<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Passport\Client;
use App\User;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_attempt_login_success()
    {
        $this->artisan('passport:client', ['--password' => true, '--no-interaction' => true]);
        $user = factory(User::class)->create([
            'username' => 'user1',
            'password' => bcrypt('secret'),
        ]);
        $client = Client::where('password_client', 1)->first();
        $client->update(['user_id' => $user->id]);

        $this->postJson('api/login', [
            'username' => 'user1',
            'password' => 'secret',
        ])
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                'token_type',
                'expires_in',
                'access_token',
                'refresh_token',
            ],
        ]);
    }

    /** @test */
    public function user_attempt_login_failed()
    {
        $this->artisan('passport:client', ['--password' => true, '--no-interaction' => true]);
        $user = factory(User::class)->create([
            'username' => 'user1',
            'password' => bcrypt('secret'),
        ]);
        $client = Client::where('password_client', 1)->first();
        $client->update(['user_id' => $user->id]);

        $this->postJson('api/login', [
            'username' => 'user1',
            'password' => 'wrong-secret',
        ])
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJson([
            'message' => 'Invalid credentials',
        ]);
    }

    /** @test */
    public function it_require_username_and_password()
    {
        $user = factory(User::class)->create([
            'username' => 'user1',
            'password' => bcrypt('secret'),
        ]);

        $this->postJson('api/login', ['username' => '', 'password' => ''])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['username', 'password']);
    }

    /** @test */
    public function inactive_user_attempt_login_failed()
    {
        factory(User::class)->create([
            'username' => 'user1',
            'password' => bcrypt('secret'),
            'active' => false,
        ]);

        $this->postJson('api/login', [
            'username' => 'user1',
            'password' => 'secret',
        ])
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJson([
            'message' => 'Invalid credentials',
        ]);
    }

    /** @test */
    public function it_revoke_auth_token_after_logout()
    {
        $this->artisan('passport:client', ['--password' => true, '--no-interaction' => true]);
        $user = factory(User::class)->create([
            'username' => 'user1',
            'password' => bcrypt('secret'),
        ]);
        $client = Client::where('password_client', 1)->first();
        $client->update(['user_id' => $user->id]);

        // Attempt to login for the purpose generating access token.
        $response = $this->postJson('api/login', [
            'username' => 'user1',
            'password' => 'secret',
        ]);

        // Set authenticated user
        $user->withAccessToken($user->fresh()->tokens()->where('revoked', false)->first());
        app('auth')->guard('api')->setUser($user);
        app('auth')->shouldUse('api');

        // Test logout end-point
        $this->postJson('api/logout')->assertStatus(200);
        $this->assertNotNull($user->fresh()->tokens()->where('revoked', true)->first());
    }
}
