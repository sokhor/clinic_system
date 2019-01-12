<?php

namespace Tests\Feature;

use App\Models\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class QueueTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_generate_a_new_queue()
    {
        $user = factory(User::class)->create();
        $user->allow('create-queues');
        $this->signIn($user);

        $this->postJson('api/queues', [])
            ->assertStatus(201);

        $this->assertDatabaseHas('queues', [
            'patient_id' => null,
            'visit_id' => null,
            'token' => 'A001',
            'counter_id' => null,
            'status' => 0, //Pending
        ]);
    }

    /** @test */
    function it_not_allow_to_generate_a_new_queue()
    {
        $this->signIn();

        $this->postJson('api/queues', [])
            ->assertStatus(403);

        $this->assertCount(0, Queue::all());
    }

    /** @test */
    function it_fetch_queues_within_today()
    {
        $user = factory(User::class)->create();
        $user->allow('view-queues');
        $this->signIn($user);

        $queue_1 = factory(Queue::class)->create();
        $queue_1->created_at = today()->subDay();
        $queue_1->save();

        $queue_2 = factory(Queue::class)->create();

        $response = $this->getJson('api/queues')
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'patient_id',
                    'visit_id',
                    'token',
                    'counter_id',
                    'status',
                ],
            ],
        ]);

        // Assert should show only today queues.
        $data = json_decode($response->getContent())->data;
        $this->assertCount(1, $data);
        $this->assertEquals($queue_2->id, $data[0]->id);
    }

    /** @test */
    function it_not_allow_to_fetch_queues()
    {
        $this->signIn();

        factory(Queue::class, 10)->create();

        $this->getJson('api/queues')
            ->assertStatus(403)
            ->assertJsonMissing(['data']);
    }
}
