<?php

namespace Tests\Feature\Queue;

use Domain\Queue\Models\QueueCounter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QueueCounterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_create_a_new_counter()
    {
        $this->signIn();

        $counter = factory(QueueCounter::class)->make();

        $this->postJson('api/queue-counters', $counter->toArray())
            ->assertStatus(201);

        $this->assertDatabaseHas('queue_counters', [
            'label' => $counter->label,
            'active' => $counter->active,
            'busy' => $counter->busy,
            'section_id' => $counter->section_id,
        ]);
    }

    /** @test */
    function it_update_a_counter()
    {
        $this->signIn();

        $counter = factory(QueueCounter::class)->create();

        $this->putJson('api/queue-counters/' . $counter->id, [
            'label' => 'other label',
            'active' => true,
            'busy' => true,
            'section_id' => $counter->section_id,
        ])->assertStatus(200);

        $this->assertDatabaseHas('queue_counters', [
            'id' => $counter->id,
            'label' => 'other label',
            'active' => true,
            'busy' => true,
            'section_id' => $counter->section_id,
        ]);
    }

    /** @test */
    function it_fetch_counters()
    {
        $this->signIn();

        factory(QueueCounter::class, 5)->create();

        $this->getJson('api/queue-counters')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'label',
                        'active',
                        'busy',
                        'section_id',
                        'section',
                    ]
                ]
            ]);
    }
}
