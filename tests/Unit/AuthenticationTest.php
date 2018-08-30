<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Passport\Client;
use App\User;

class AuthenticationTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_should_return_access_and_refresh_token_if_user_with_given_username_and_password_exists()
    {
        $this->artisan('passport:client', ['--password' => true, '--no-interaction' => true]);
        factory(User::class)->create([
            'username' => 'user1',
            'password' => bcrypt('secret'),
        ]);
        $client = Client::where('password_client', 1)->first();

        $this->postJson('/oauth/token', [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => 'user1',
            'password' => 'secret',
            'scope' => '*',
        ])
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'token_type',
            'expires_in',
            'access_token',
            'refresh_token',
        ]);
    }
}
