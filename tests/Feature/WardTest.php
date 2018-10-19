<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Place\Models\Ward;

class WardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_fetch_wards()
    {
        $user = factory(User::class)->create();
        $user->allow('view-wards');
        $this->signIn($user);

        $this->getJson('api/wards')
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name_kh',
                    'name_en',
                ],
            ],
        ]);
    }

    /** @test */
    function it_no_permision_to_fetch_wards()
    {
        $this->signIn();

        $this->getJson('api/wards')
            ->assertStatus(403)
            ->assertJsonMissing(['data']);
    }

    /** @test */
    function it_create_a_ward()
    {
        $user = factory(User::class)->create();
        $user->allow('create-wards');
        $this->signIn($user);

        $ward = factory(Ward::class)->make();

        $this->postJson('api/wards', $ward->toArray())
            ->assertStatus(201);

        $this->assertDatabaseHas('wards', $ward->toArray());
    }

    /** @test */
    function it_no_permission_to_create_a_ward()
    {
        $this->signIn();

        $ward = factory(Ward::class)->make();

        $this->postJson('api/wards', $ward->toArray())
            ->assertStatus(403);

        $this->assertDatabaseMissing('wards', $ward->toArray());
    }
}
