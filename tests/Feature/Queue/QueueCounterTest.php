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
}
