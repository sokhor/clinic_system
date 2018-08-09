<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UserAdministrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthorized_user_cannot_create_a_user()
    {
        $this->signIn();

        $user = factory(User::class)->make();

        $this->postJson('api/users', array_merge($user->toArray(), ['password' => 'secret']))
            ->assertStatus(403);

        $this->assertDatabaseMissing('users', $user->toArray());
    }

    /** @test */
    public function authorized_user_can_create_a_user()
    {
        $sign_in_user = factory(User::class)->create();
        $sign_in_user->allow('create-users');
        $this->signIn($sign_in_user);

        $user = factory(User::class)->make();

        $this->postJson('api/users', array_merge($user->toArray(), ['password' => 'secret']))
            ->assertStatus(201);

        $this->assertDatabaseHas('users', $user->toArray());
    }

     /** @test */
    public function unauthorized_user_cannot_edit_a_user()
    {
        $this->signIn();

        $user = factory(User::class)->create();
        $user->email = 'edit@mail.com';

        $this->putJson("api/users/{$user->id}", $user->toArray())
            ->assertStatus(403);

        $this->assertDatabaseMissing('users', $user->toArray());
    }

    /** @test */
    public function authorized_user_can_edit_a_user()
    {
        $sign_in_user = factory(User::class)->create();
        $sign_in_user->allow('edit-users');
        $this->signIn($sign_in_user);

        $user = factory(User::class)->create();
        $user->email = 'edit@mail.com';
        $user->active = true;

        $this->putJson("api/users/{$user->id}", $user->toArray())
            ->assertStatus(200);

        $this->assertDatabaseHas('users', $user->toArray());
    }

    /** @test */
    public function username_cannot_change()
    {
        $sign_in_user = factory(User::class)->create();
        $sign_in_user->allow('edit-users');
        $this->signIn($sign_in_user);

        $user = factory(User::class)->create();
        $user->username = 'anotherusername';
        $user->email = 'edit@mail.com';

        $this->putJson("api/users/{$user->id}", $user->toArray());

        $this->assertDatabaseMissing('users', $user->toArray());
    }
}
