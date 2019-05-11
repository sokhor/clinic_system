<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Bouncer;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authorized_user_can_create_a_user()
    {
        $user = factory(User::class)->make();

        $this->signIn()
            ->allow('create-users')
            ->postJson('api/users', array_merge($user->toArray(), ['password' => 'secret']))
            ->assertStatus(201);

        $this->assertDatabaseHas('users', $user->toArray());

        $user = User::where('username', $user->username)->first();
        $this->assertCount(1, $user->clients);
    }

    /** @test */
    public function unauthorized_user_cannot_create_a_user()
    {
        $user = factory(User::class)->make();

        $this->signIn()
            ->postJson('api/users', array_merge($user->toArray(), ['password' => 'secret']))
            ->assertStatus(403);

        $this->assertDatabaseMissing('users', $user->toArray());
    }

    /** @test */
    public function authorized_user_can_edit_a_user()
    {
        $user = factory(User::class)->create();
        $updatingData = ['email' => 'edit@mail.com'];

        $this->signIn()
            ->allow('edit-users')
            ->putJson("api/users/{$user->id}", $updatingData)
            ->assertStatus(200);

        $this->assertEquals($updatingData, $user->fresh()->only(['email']));
    }

    /** @test */
    public function unauthorized_user_cannot_edit_a_user()
    {
        $user = factory(User::class)->create();
        $updatingData = ['email' => 'edit@mail.com'];

        $this->signIn()
            ->putJson("api/users/{$user->id}", $updatingData)
            ->assertStatus(403);

        $this->assertNotEquals($updatingData, $user->fresh()->only(['email']));
    }

    /** @test */
    public function authorized_user_can_delete_a_user()
    {
        $user = factory(User::class)->create();

        $this->signIn()
            ->allow('delete-users')
            ->deleteJson("api/users/{$user->id}")
            ->assertStatus(200);

        $this->assertDatabaseHas('users', $user->toArray());
        $this->assertNotNull($user->fresh()->deleted_at);
    }

    /** @test */
    public function unauthorized_user_cannot_delete_a_user()
    {
        $user = factory(User::class)->create();

        $this->signIn()
            ->deleteJson("api/users/{$user->id}")
            ->assertStatus(403);

        $this->assertDatabaseHas('users', $user->toArray());
        $this->assertNull($user->fresh()->deleted_at);
    }

    /** @test */
    public function username_cannot_change()
    {
        $user = factory(User::class)->create();
        $updatedData = ['username' => 'anotherusername'];

        $this->signIn()
            ->allow('edit-users')
            ->putJson("api/users/{$user->id}", $updatedData);

        $this->assertNotEquals($updatedData, $user->fresh()->only(['username']));
    }

    /** @test */
    public function authorized_user_can_reset_a_user_password()
    {
        $user = factory(User::class)->create(['password' => bcrypt('12345678')]);
        $resetPasswordData = [
            'password' => '87654321',
            'password_confirmation' => '87654321',
        ];

        $this->signIn()
            ->allow('reset-password-users')
            ->putJson("api/users/{$user->id}/password/reset", $resetPasswordData)
            ->assertStatus(200);

        $this->assertTrue(Hash::check($resetPasswordData['password'], $user->fresh()->password));
    }

    /** @test */
    public function unauthorized_user_cannot_reset_a_user_password()
    {
        $user = factory(User::class)->create(['password' => bcrypt('12345678')]);
        $resetPasswordData = [
            'password' => '87654321',
            'password_confirmation' => '87654321',
        ];

        $this->signIn()
            ->putJson("api/users/{$user->id}/password/reset", $resetPasswordData)
            ->assertStatus(403);

        $this->assertFalse(Hash::check($resetPasswordData['password'], $user->fresh()->password));
    }

    /** @test */
    public function super_admin_never_show_to_the_public()
    {
        $this->signInSuperAdmin();

        $this->getJson('api/users')
            ->assertJsonMissing(['username' => 'superadmin']);
    }

    /** @test */
    public function authorize_user_can_view_users()
    {
        factory(User::class, 2)->create();

        $this->signIn()
            ->allow('view-users')
            ->getJson('api/users')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'username',
                        'email',
                    ],
                ],
            ]);
    }

    /** @test */
    public function unauthorize_user_cannot_view_users()
    {
        factory(User::class, 2)->create();

        $this->signIn()
            ->getJson('api/users')
            ->assertStatus(403)
            ->assertJsonMissing(['data']);
    }

    /** @test */
    public function authorize_user_can_view_a_user()
    {
        $user = factory(User::class)->create(['id' => 10]);

        $this->signIn()
            ->allow('view-users')
            ->getJson("api/users/$user->id")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'username',
                    'email',
                ],
            ]);
    }

    /** @test */
    public function unauthorize_user_cannot_view_a_user()
    {
        $user = factory(User::class)->create();

        $this->signIn()
            ->getJson("api/users/$user->id")
            ->assertStatus(403)
            ->assertJsonMissing([
                'username',
                'email',
            ]);
    }

    /** @test */
    public function attach_user_roles()
    {
        $user = factory(User::class)->create();

        Bouncer::ability()->firstOrCreate(['name' => 'role-test-1', 'title' => 'Role test 1']);
        Bouncer::ability()->firstOrCreate(['name' => 'role-test-2', 'title' => 'Role test 2']);

        $this->signIn()
            ->allow('attach-roles-users')
            ->postJson("api/users/$user->id/roles", [
                'roles' => ['role-test-1', 'role-test-2']
            ])
            ->assertStatus(201);

        $this->assertCount(2, $user->fresh()->roles);
    }

    /** @test */
    public function cannot_attach_user_roles()
    {
        $user = factory(User::class)->create();

        Bouncer::ability()->firstOrCreate(['name' => 'role-test-1', 'title' => 'Role test 1']);
        Bouncer::ability()->firstOrCreate(['name' => 'role-test-2', 'title' => 'Role test 2']);

        $this->signIn()
            ->postJson("api/users/$user->id/roles", [
                'roles' => ['role-test-1', 'role-test-2']
            ])->assertStatus(403);

        $this->assertCount(0, $user->fresh()->roles);
    }

    /** @test */
    public function detach_user_roles()
    {
        $user = factory(User::class)->create();

        Bouncer::ability()->firstOrCreate(['name' => 'role-test-1', 'title' => 'Role test 1']);
        Bouncer::assign('role-test-1')->to($user);

        $this->assertCount(1, $user->fresh()->roles);

        $this->signIn()
            ->allow('detach-roles-users')
            ->putJson("api/users/$user->id/roles", [
                'roles' => ['role-test-1']
            ])
            ->assertStatus(200);

        $this->assertCount(0, $user->fresh()->roles);
    }

    /** @test */
    public function cannot_detach_user_roles()
    {
        $user = factory(User::class)->create();

        Bouncer::ability()->firstOrCreate(['name' => 'role-test-1', 'title' => 'Role test 1']);
        Bouncer::assign('role-test-1')->to($user);

        $this->signIn()
            ->putJson("api/users/$user->id/roles", [
                'roles' => ['role-test-1']
            ])
            ->assertStatus(403);

        $this->assertCount(1, $user->fresh()->roles);
    }
}
