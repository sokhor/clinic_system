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
    {
        $this->signIn();

        $queue_section = factory(QueueSection::class)->make(['name' => 'Doctor Consulting']);

        $this->postJson('api/queue-sections', $queue_section->toArray())
            ->assertStatus(201);

        $this->assertDatabaseHas('queue_sections', [
            'name' => $queue_section->name,
            'active' => $queue_section->active,
        ]);
    }

    /** @test */
    function it_fetch_sections()
    {
        $this->signIn();

        factory(QueueSection::class, 5)->create();

        $this->getJson('api/queue-sections')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'active',
                    ]
                ]
            ]);
    }
}
