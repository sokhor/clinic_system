<?php

namespace Tests\Feature;

use App\Place\Models\Building;
use App\Place\Models\Ward;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BuildingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_fetch_buildings()
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
                    'wards',
                ],
            ],
        ]);
    }

    /** @test */
    public function it_not_allow_to_fetch_buildings()
    {
        $this->signIn();

        factory(Building::class, 5)->create();

        $this->getJson('api/buildings')
        ->assertStatus(403)
        ->assertJsonMissing(['data']);
    }

    /** @test */
    public function it_show_a_building()
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
                'wards',
            ],
        ]);
    }

    /** @test */
    public function it_not_allow_to_show_a_building()
    {
        $this->signIn();

        $building = factory(Building::class)->create();

        $this->getJson("api/buildings/{$building->id}")
        ->assertStatus(403)
        ->assertJsonMissing(['data']);
    }

    /** @test */
    public function it_create_a_building()
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
    public function it_not_allow_to_create_a_building()
    {
        $this->signIn();

        $building = factory(Building::class)->make();

        $this->postJson('api/buildings', $building->toArray())
            ->assertStatus(403);

        $this->assertDatabaseMissing('buildings', $building->toArray());
    }

    /** @test */
    public function it_edit_a_building()
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
    public function it_not_allow_to_edit_a_building()
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

    /** @test */
    public function it_delete_a_building()
    {
        $user = factory(User::class)->create();
        $user->allow('delete-buildings');
        $this->signIn($user);

        $building = factory(Building::class)->create();

        $this->assertDatabaseHas('buildings', $building->toArray());

        $this->deleteJson("api/buildings/{$building->id}")
            ->assertStatus(200);

        $this->assertDatabaseMissing('buildings', $building->toArray());
    }

    /** @test */
    public function it_not_allow_to_delete_a_building()
    {
        $this->signIn();

        $building = factory(Building::class)->create();

        $this->deleteJson("api/buildings/{$building->id}")
            ->assertStatus(403);

        $this->assertDatabaseHas('buildings', $building->toArray());
    }

    /** @test */
    public function it_attach_wards_to_a_building()
    {
        $user = factory(User::class)->create();
        $user->allow('attach-wards-buildings');
        $this->signIn($user);

        $wards = factory(Ward::class, 3)->create();
        $building = factory(Building::class)->create();

        $this->putJson("api/buildings/{$building->id}/wards", $wards->pluck('id')->toArray())
        ->assertStatus(200);

        $this->assertCount(3, $building->fresh()->wards);
    }

    /** @test */
    public function it_not_allow_to_attach_wards_to_a_building()
    {
        $this->signIn();

        $wards = factory(Ward::class, 3)->create();
        $building = factory(Building::class)->create();

        $this->putJson("api/buildings/{$building->id}/wards", $wards->pluck('id')->toArray())
        ->assertStatus(403);

        $this->assertCount(0, $building->fresh()->wards);
    }

    /** @test */
    public function it_detach_wards_from_a_building()
    {
        $user = factory(User::class)->create();
        $user->allow('attach-wards-buildings');
        $this->signIn($user);

        $wards = factory(Ward::class, 3)->create();
        $building = factory(Building::class)->create();

        $building->wards()->attach($wards->pluck('id'));
        $this->assertCount(3, $building->fresh()->wards);

        $this->putJson("api/buildings/{$building->id}/wards", [ $wards[0]->id, $wards[2]->id ])
        ->assertStatus(200);

        $this->assertCount(2, $building->fresh()->wards);
        $this->assertEquals(
            [ $wards[0]->id, $wards[2]->id ],
            $building->fresh()->wards->pluck('id')->toArray()
        );
    }

    /** @test */
    public function it_not_allow_to_detach_wards_from_a_building()
    {
        $this->signIn();

        $wards = factory(Ward::class, 3)->create();
        $building = factory(Building::class)->create();
        $building->wards()->attach($wards->pluck('id'));

        $this->putJson("api/buildings/{$building->id}/wards", [ $wards[0]->id, $wards[2]->id ])
        ->assertStatus(403);

        $this->assertCount(3, $building->fresh()->wards);
        $this->assertNotEquals(
            [ $wards[0]->id, $wards[2]->id ],
            $building->fresh()->wards->pluck('id')->toArray()
        );
    }
}
