<?php

namespace Tests\Feature;

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
            'token_type',
            'expires_in',
            'access_token',
            'refresh_token',
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
        ->assertStatus(Response::HTTP_UNAUTHORIZED)
        ->assertJson([
            'error' => 'Unauthenticated',
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
}
