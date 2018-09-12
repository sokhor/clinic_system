<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Bouncer;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function authorized_user_create_a_role()
    {
        $sign_in_user = factory(User::class)->create();
        $sign_in_user->allow('create-roles');
        $this->signIn($sign_in_user);

        $role = [
            'name' => 'role-name',
            'title' => 'Role name',
        ];

        $this->postJson('api/roles', $role)
            ->assertStatus(201);

        $this->assertDatabaseHas('roles', $role);
    }

    /** @test */
    function unauthorized_user_cannot_create_a_role()
    {
        $this->signIn();

        $role = [
            'name' => 'role-name',
            'title' => 'Role name',
        ];

        $this->postJson('api/roles', $role)
            ->assertStatus(403);

        $this->assertDatabaseMissing('roles', $role);
    }
    /** @test */
    function authorized_user_edit_role()
    {
        $sign_in_user = factory(User::class)->create();
        $sign_in_user->allow('edit-roles');
        $this->signIn($sign_in_user);

        $role = Bouncer::role()->create([
            'name' => 'role-name',
            'title' => 'Role name',
        ]);

        $this->putJson('api/roles/' . $role->id, [
            'name' => 'role-new-name',
            'title' => 'Role new name',
        ])->assertStatus(200);

        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'name' => 'role-new-name',
            'title' => 'Role new name',
        ]);
    }

    /** @test */
    function unauthorized_user_cannot_edit_role()
    {
        $this->signIn();

        $role = Bouncer::role()->create([
            'name' => 'role-name',
            'title' => 'Role name',
        ]);

        $this->putJson('api/roles/' . $role->id, [
            'name' => 'role-new-name',
            'title' => 'Role new name',
        ])->assertStatus(403);

        $this->assertDatabaseMissing('roles', [
            'id' => $role->id,
            'name' => 'role-new-name',
            'title' => 'Role new name',
        ]);
    }

    /** @test */
    function name_title_fields_required()
    {
        $sign_in_user = factory(User::class)->create();
        $sign_in_user->allow('create-roles');
        $sign_in_user->allow('edit-roles');
        $this->signIn($sign_in_user);

        $this->postJson('api/roles', [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'title']);

        $role = Bouncer::role()->create([
            'name' => 'role-name',
            'title' => 'Role name',
        ]);

        $this->putJson('api/roles/' . $role->id , [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'title']);
    }

    /** @test */
    function it_fetch_roles()
    {
        $sign_in_user = factory(User::class)->create();
        $sign_in_user->allow('view-roles');
        $this->signIn($sign_in_user);

        Bouncer::role()->create([
            'name' => 'role-name-1',
            'title' => 'Role name-1',
        ]);

        Bouncer::role()->create([
            'name' => 'role-name-2',
            'title' => 'Role name-2',
        ]);

        $this->getJson('api/roles')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'name',
                        'title',
                    ],
                ],
            ]);
    }

    /** @test */
    function it_not_allow_to_fetch_roles()
    {
        $this->signIn();

        Bouncer::role()->create([
            'name' => 'role-name-1',
            'title' => 'Role name-1',
        ]);

        Bouncer::role()->create([
            'name' => 'role-name-2',
            'title' => 'Role name-2',
        ]);

        $this->getJson('api/roles')
            ->assertStatus(403)
            ->assertJsonMissing(['data']);
    }

    /** @test */
    function it_delete_role()
    {
        $sign_in_user = factory(User::class)->create();
        $sign_in_user->allow('delete-roles');
        $this->signIn($sign_in_user);

        $role = Bouncer::role()->create([
            'name' => 'role-name',
            'title' => 'Role name',
        ]);

        $this->assertDatabaseHas('roles', $role->toArray());

        $this->deleteJson('api/roles/' . $role->id)
            ->assertStatus(200);

        $this->assertDatabaseMissing('roles',$role->toArray());
    }

    /** @test */
    function it_not_allow_to_delete_role()
    {
        $this->signIn();

        $role = Bouncer::role()->create([
            'name' => 'role-name',
            'title' => 'Role name',
        ]);

        $this->deleteJson('api/roles/' . $role->id)
            ->assertStatus(403);

        $this->assertDatabaseHas('roles', $role->toArray());
    }
}
