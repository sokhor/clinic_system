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
}
