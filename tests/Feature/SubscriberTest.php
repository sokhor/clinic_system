<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class SubscriberTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function create_a_subscriber_user()
    {
        $user = factory(User::class)->raw();

        $response = $this->postJson('api/register', array_merge($user, [
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ]));

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'username' => $user['username'],
            'email' => $user['email'],
            'active' => $user['active'],
            'user_id' => null,
        ]);
        $this->assertDatabaseHas('companies', [
            'user_id' => json_decode($response->getContent())->data->id,
        ]);
    }
}
