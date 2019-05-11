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
    public function it_fetch_wards()
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
    public function it_not_allow_to_fetch_wards()
    {
        $this->signIn();

        $this->getJson('api/wards')
            ->assertStatus(403)
            ->assertJsonMissing(['data']);
    }

    /** @test */
    public function it_show_a_ward()
    {
        $user = factory(User::class)->create();
        $user->allow('view-wards');
        $this->signIn($user);

        $ward = factory(Ward::class)->create();

        $this->getJson("api/wards/{$ward->id}")
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
    public function it_not_allow_to_show_a_ward()
    {
        $this->signIn();

        $ward = factory(Ward::class)->create();

        $this->getJson("api/wards/{$ward->id}")
        ->assertStatus(403)
        ->assertJsonMissing(['data']);
    }

    /** @test */
    public function it_create_a_ward()
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
    public function it_not_allow_to_create_a_ward()
    {
        $this->signIn();

        $ward = factory(Ward::class)->make();

        $this->postJson('api/wards', $ward->toArray())
            ->assertStatus(403);

        $this->assertDatabaseMissing('wards', $ward->toArray());
    }

    /** @test */
    public function it_edit_a_ward()
    {
        $user = factory(User::class)->create();
        $user->allow('update-wards');
        $this->signIn($user);

        $ward = factory(Ward::class)->create();

        $this->putJson('api/wards/' . $ward->id, [
            'name_kh' => 'កខគ',
            'name_en' => 'ward-1',
        ])->assertStatus(200);

        $this->assertDatabaseHas('wards', [
            'id' => $ward->id,
            'name_kh' => 'កខគ',
            'name_en' => 'ward-1',
        ]);
    }

    /** @test */
    public function it_not_allow_to_edit_a_ward()
    {
        $this->signIn();

        $ward = factory(Ward::class)->create();

        $this->putJson('api/wards/' . $ward->id, [
            'name_kh' => 'កខគ',
            'name_en' => 'ward-1',
        ])->assertStatus(403);

        $this->assertDatabaseMissing('wards', [
            'id' => $ward->id,
            'name_kh' => 'កខគ',
            'name_en' => 'ward-1',
        ]);
    }

    /** @test */
    public function it_delete_a_ward()
    {
        $user = factory(User::class)->create();
        $user->allow('delete-wards');
        $this->signIn($user);

        $ward = factory(Ward::class)->create();

        $this->assertDatabaseHas('wards', $ward->toArray());

        $this->deleteJson('api/wards/' . $ward->id)
            ->assertStatus(200);

        $this->assertDatabaseMissing('wards', $ward->toArray());
    }

    /** @test */
    public function it_not_allow_to_delete_a_ward()
    {
        $this->signIn();

        $ward = factory(Ward::class)->create();

        $this->deleteJson('api/wards/' . $ward->id)
            ->assertStatus(403);

        $this->assertDatabaseHas('wards', $ward->toArray());
    }
}
