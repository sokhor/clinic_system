<?php

namespace Tests\Feature;

use App\Place\Models\Room;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoomTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_fetch_rooms()
    {
        $user = factory(User::class)->create();
        $user->allow('view-rooms');
        $this->signIn($user);

        factory(Room::class, 5)->create();

        $this->getJson('api/rooms')
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'building_id',
                    'ward_id',
                    'name_kh',
                    'name_en',
                    'code',
                    'price',
                    'floor',
                    'status',
                ],
            ],
        ]);
    }

    /** @test */
    public function it_not_allow_to_fetch_rooms()
    {
        $this->signIn();

        factory(Room::class, 5)->create();

        $this->getJson('api/rooms')
        ->assertStatus(403)
        ->assertJsonMissing(['data']);
    }

    /** @test */
    public function it_show_a_room()
    {
        $user = factory(User::class)->create();
        $user->allow('view-rooms');
        $this->signIn($user);

        $room = factory(Room::class)->create();

        $this->getJson("api/rooms/{$room->id}")
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'id',
                'building_id',
                'ward_id',
                'name_kh',
                'name_en',
                'code',
                'price',
                'floor',
                'status',
            ],
        ]);
    }

    /** @test */
    public function it_not_allow_to_show_a_room()
    {
        $this->signIn();

        $room = factory(Room::class)->create();

        $this->getJson("api/rooms/{$room->id}")
        ->assertStatus(403)
        ->assertJsonMissing(['data']);
    }

    /** @test */
    public function it_create_a_room()
    {
        $user = factory(User::class)->create();
        $user->allow('create-rooms');
        $this->signIn($user);

        $room = factory(Room::class)->make();

        $this->postJson('api/rooms', $room->toArray())
        ->assertStatus(201);

        $this->assertDatabaseHas('rooms', $room->toArray());
    }

    /** @test */
    public function it_create_a_room_and_dont_meet_required_fields()
    {
        $user = factory(User::class)->create();
        $user->allow('create-rooms');
        $this->signIn($user);

        $this->postJson('api/rooms', [])
        ->assertStatus(422)
        ->assertJsonValidationErrors([
            'building_id',
            'name_kh',
            'name_en',
            'status',
        ]);

        $this->assertCount(0, Room::all());
    }

    /** @test */
    public function it_not_allow_to_create_a_room()
    {
        $this->signIn();

        $room = factory(Room::class)->make();

        $this->postJson('api/rooms', $room->toArray())
            ->assertStatus(403);

        $this->assertDatabaseMissing('rooms', $room->toArray());
    }

    /** @test */
    public function it_edit_a_room()
    {
        $user = factory(User::class)->create();
        $user->allow('update-rooms');
        $this->signIn($user);

        $room = factory(Room::class)->create();

        $this->putJson("api/rooms/{$room->id}", [
            'name_kh' => 'បន្ទប់ទី១០',
            'name_en' => 'room 10',
            'building_id' => 4,
            'status' => 1,
        ])->assertStatus(200);

        $this->assertDatabaseHas('rooms', [
            'id' => $room->id,
            'name_kh' => 'បន្ទប់ទី១០',
            'name_en' => 'room 10',
            'building_id' => 4,
            'status' => 1,
        ]);
    }

    /** @test */
    public function it_edit_a_room_and_dont_meet_required_fields()
    {
        $user = factory(User::class)->create();
        $user->allow('update-rooms');
        $this->signIn($user);

        $room = factory(Room::class)->create();

        $this->putJson("api/rooms/{$room->id}", [])
        ->assertStatus(422)
        ->assertJsonValidationErrors([
            'building_id',
            'name_kh',
            'name_en',
            'status',
        ]);

        $this->assertDatabaseHas('rooms', $room->toArray());
    }

    /** @test */
    public function it_not_allow_to_edit_a_room()
    {
        $this->signIn();

        $room = factory(Room::class)->create();

        $this->putJson("api/rooms/{$room->id}", [
            'name_kh' => 'បន្ទប់ទី១០',
            'name_en' => 'room 10',
            'building_id' => 4,
            'status' => 1,
        ])->assertStatus(403);

        $this->assertDatabaseHas('rooms', $room->toArray());
    }

    /** @test */
    public function it_delete_a_room()
    {
        $user = factory(User::class)->create();
        $user->allow('delete-rooms');
        $this->signIn($user);

        $room = factory(Room::class)->create();

        $this->assertDatabaseHas('rooms', $room->toArray());

        $this->deleteJson("api/rooms/{$room->id}")
            ->assertStatus(200);

        $this->assertDatabaseMissing('rooms', $room->toArray());
    }

    /** @test */
    public function it_not_allow_to_delete_a_room()
    {
        $this->signIn();

        $room = factory(Room::class)->create();

        $this->deleteJson("api/rooms/{$room->id}")
            ->assertStatus(403);

        $this->assertDatabaseHas('rooms', $room->toArray());
    }
}
