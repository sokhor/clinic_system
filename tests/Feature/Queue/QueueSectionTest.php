<?php

namespace Tests\Feature\Queue;

use Domain\Queue\Models\QueueSection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QueueSectionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_create_queue_section()
    {$this->withoutExceptionHandling();
        $this->signIn();

        $queue_section = factory(QueueSection::class)->make(['name' => 'Doctor Consulting']);

        $this->postJson('api/queue-section', $queue_section->toArray())
            ->assertStatus(201);

        $this->assertDatabaseHas('queue_sections', [
            'name' => $queue_section->name,
            'active' => $queue_section->active,
        ]);
    }
}
