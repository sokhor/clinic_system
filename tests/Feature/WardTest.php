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
            ->assertJsonMissing(['data']);;
    }
}
