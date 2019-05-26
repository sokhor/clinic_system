<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Domain\Administration\Models\Company;
use Bouncer;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function create_a_user()
    {
        $subscriber = factory(User::class)->state('subscriber')->create();
        $user = factory(User::class)->raw(['user_id' =>  null]);

        $response = $this->signIn($subscriber)
            ->allow('create-users')
            ->postJson('api/users', array_merge($user, [
                'password' => 'secret',
                'password_confirmation' => 'secret',
            ]));

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'username' => $user['username'],
            'email' => $user['email'],
            'active' => $user['active'],
            'user_id' => $subscriber->id,
        ]);
        $this->assertCount(1, Company::get());
        $this->assertEquals($subscriber->id, Company::first()->user_id);
    }

    /** @test */
    public function it_validate_required_fields_when_creating_a_user()
    {
        $user = factory(User::class)->make();

        $this->signIn()
            ->allow('create-users')
            ->postJson('api/users', [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['username', 'password']);

        $this->assertDatabaseMissing('users', $user->toArray());
    }

    /** @test */
    public function password_mismatch_when_creating_a_user()
    {
        $user = factory(User::class)->make();

        $this->signIn()
            ->allow('create-users')
            ->postJson('api/users', array_merge($user->toArray(), ['password' => 'secret']))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['password']);

        $this->assertDatabaseMissing('users', $user->toArray());
    }

    /** @test */
    public function username_is_unique_when_creating_a_user()
    {
        factory(User::class)->create(['username' => 'user1']);
        $user = factory(User::class)->make(['username' => 'user1']);

        $this->signIn()
            ->allow('create-users')
            ->postJson('api/users', array_merge($user->toArray(), ['password' => 'secret']))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['username']);

        $this->assertDatabaseMissing('users', $user->toArray());
    }

    /** @test */
    public function email_is_unique_but_nullable_when_creating_a_user()
    {
        // Unique email
        factory(User::class)->create(['email' => 'user1@mail.com']);
        $user = factory(User::class)->make(['email' => 'user1@mail.com']);

        $this->signIn()
            ->allow('create-users')
            ->postJson('api/users', array_merge($user->toArray(), [
                'password' => 'secret',
                'password_confirmation' => 'secret',
            ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email']);

        $this->assertDatabaseMissing('users', $user->toArray());

        // Nullable
        $this->signIn()
            ->allow('create-users')
            ->postJson('api/users', array_merge($user->toArray(), [
                'password' => 'secret',
                'password_confirmation' => 'secret',
                'email' => '',
            ]))
            ->assertStatus(201);
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
        $updatingData = ['active' => false];

        $this->signIn()
            ->allow('edit-users')
            ->putJson("api/users/{$user->id}", $updatingData)
            ->assertStatus(200);

        $this->assertEquals($updatingData, $user->fresh()->only(['active']));
    }

    /** @test */
    public function email_is_unique_but_nullable_when_editing_a_user()
    {
        // Unique email
        factory(User::class)->create(['email' => 'user1@mail.com']);
        $user = factory(User::class)->create();
        $updatingData = ['email' => 'user1@mail.com'];

        $this->signIn()
            ->allow('edit-users')
            ->putJson("api/users/{$user->id}", $updatingData)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email']);

        $this->assertNotEquals($updatingData, $user->fresh()->only(['email']));

        // Ignore user's email
        $user = factory(User::class)->create(['email' => 'user2@mail.com']);

        $this->signIn()
            ->allow('edit-users')
            ->putJson("api/users/{$user->id}", ['email' => 'user2@mail.com'])
            ->assertStatus(200);

        // Nullable
        factory(User::class)->create(['email' => null]);

        $this->signIn()
            ->allow('edit-users')
            ->putJson("api/users/{$user->id}", ['email' => ''])
            ->assertStatus(200);
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

        $this->assertNotNull($user->fresh()->deleted_at);
    }

    /** @test */
    public function unauthorized_user_cannot_delete_a_user()
    {
        $user = factory(User::class)->create();

        $this->signIn()
            ->deleteJson("api/users/{$user->id}")
            ->assertStatus(403);

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
            ->assertStatus(200);

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
        $this->withoutExceptionHandling();
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
