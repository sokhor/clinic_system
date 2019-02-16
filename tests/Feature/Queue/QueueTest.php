<?php

namespace Tests\Feature\Queue;

use App\User;
use Domain\Queue\Models\Queue;
use Domain\Queue\Models\QueueCounter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QueueTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_generate_a_new_queue()
    {
        $this->signIn()->allow('create', Queue::class);

        $this->postJson('api/queues', [])
            ->assertStatus(201);

        $this->assertDatabaseHas('queues', [
            'ticket' => '01',
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
        $this->signIn()->allow('view', Queue::class);

        $queue_1 = factory(Queue::class)->create();
        $queue_1->created_at = today()->subDay();
        $queue_1->save();

        $queue_2 = factory(Queue::class)->create();

        $response = $this->getJson('api/queues')
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'ticket',
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

    /** @test */
    function it_set_queue_counter()
    {
        $this->signIn()->allow('update', Queue::class);

        $counter_1 = factory(QueueCounter::class)->state('inactive')->create();
        $counter_2 = factory(QueueCounter::class)->state('available')->create();
        $counter_3 = factory(QueueCounter::class)->state('busy')->create();
        $queue = factory(Queue::class)->create();

        $this->assertNull($queue->counter_id);

        $this->putJson("api/queues/{$queue->id}/counter")
            ->assertStatus(200);

        $this->assertEquals($counter_2->id, $queue->fresh()->counter_id);
        $this->assertTrue($counter_2->fresh()->active);
        $this->assertTrue($counter_2->fresh()->busy);
    }

    /** @test */
    function no_queue_counter_available()
    {
        $this->signIn()->allow('update', Queue::class);

        $counter_1 = factory(QueueCounter::class)->state('inactive')->create();
        $counter_3 = factory(QueueCounter::class)->state('busy')->create();
        $queue = factory(Queue::class)->create();

        $this->putJson("api/queues/{$queue->id}/counter")
            ->assertStatus(200);

        $this->assertNull($queue->fresh()->counter_id);
    }

    /** @test */
    function it_not_allow_to_set_counter()
    {
        $this->signIn();

        $counter_2 = factory(QueueCounter::class)->state('available')->create();
        $queue = factory(Queue::class)->create();

        $this->assertNull($queue->counter_id);

        $this->putJson("api/queues/{$queue->id}/counter")
            ->assertStatus(403);

        $this->assertNull($queue->fresh()->counter_id);
        $this->assertTrue($counter_2->fresh()->active);
        $this->assertFalse($counter_2->fresh()->busy);
    }
}
