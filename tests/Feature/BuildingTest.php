<?php

namespace Tests\Feature;

use App\Place\Models\Building;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BuildingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_fetch_buildings()
    {
        $user = factory(User::class)->create();
        $user->allow('view-buildings');
        $this->signIn($user);

        factory(Building::class, 5)->create();

        $this->getJson('api/buildings')
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
    function it_not_allow_to_fetch_buildings()
    {
        $this->signIn();

        factory(Building::class, 5)->create();

        $this->getJson('api/buildings')
        ->assertStatus(403)
        ->assertJsonMissing(['data']);
    }

    /** @test */
    function it_show_a_building()
    {
        $user = factory(User::class)->create();
        $user->allow('view-buildings');
        $this->signIn($user);

        $building = factory(Building::class)->create();

        $this->getJson("api/buildings/{$building->id}")
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'id',
                'name_kh',
                'name_en',
            ],
        ]);
    }

    /** @test */
    function it_not_allow_to_show_a_building()
    {
        $this->signIn();

        $building = factory(Building::class)->create();

        $this->getJson("api/buildings/{$building->id}")
        ->assertStatus(403)
        ->assertJsonMissing(['data']);
    }

    /** @test */
    function it_create_a_building()
    {
        $user = factory(User::class)->create();
        $user->allow('create-buildings');
        $this->signIn($user);

        $building = factory(Building::class)->make();

        $this->postJson('api/buildings', $building->toArray())
            ->assertStatus(201);

        $this->assertDatabaseHas('buildings', $building->toArray());
    }

    /** @test */
    function it_not_allow_to_create_a_building()
    {
        $this->signIn();

        $building = factory(Building::class)->make();

        $this->postJson('api/buildings', $building->toArray())
            ->assertStatus(403);

        $this->assertDatabaseMissing('buildings', $building->toArray());
    }

    /** @test */
    function it_edit_a_building()
    {
        $user = factory(User::class)->create();
        $user->allow('update-buildings');
        $this->signIn($user);

        $building = factory(Building::class)->create();

        $this->putJson("api/buildings/{$building->id}", [
            'name_kh' => 'អាគារទី១',
            'name_en' => 'Building 1',
        ])->assertStatus(200);

        $this->assertDatabaseHas('buildings', [
            'id' => $building->id,
            'name_kh' => 'អាគារទី១',
            'name_en' => 'Building 1',
        ]);
    }

    /** @test */
    function it_not_allow_to_edit_a_building()
    {
        $this->signIn();

        $building = factory(Building::class)->create();

        $this->putJson("api/buildings/{$building->id}", [
            'name_kh' => 'អាគារទី១',
            'name_en' => 'Building 1',
        ])->assertStatus(403);

        $this->assertDatabaseMissing('buildings', [
            'id' => $building->id,
            'name_kh' => 'អាគារទី១',
            'name_en' => 'Building 1',
        ]);
    }
}
