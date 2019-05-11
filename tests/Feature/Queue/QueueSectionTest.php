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
    public function it_create_queue_section()
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
    public function it_update_a_queue_section()
    {
        $this->signIn();

        $queue_section = factory(QueueSection::class)->create();

        $this->putJson('api/queue-sections/' . $queue_section->id, [
            'name' => 'Nurse and midwife',
            'active' => true,
        ])->assertStatus(200);

        $this->assertDatabaseHas('queue_sections', [
            'id' => $queue_section->id,
            'name' => 'Nurse and midwife',
            'active' => true,
        ]);
    }

    /** @test */
    public function it_delete_a_queue_section()
    {
        $this->signIn();

        $queue_section = factory(QueueSection::class)->create();

        $this->deleteJson('api/queue-sections/' . $queue_section->id)
            ->assertStatus(200);

        $this->assertDatabaseMissing('queue_sections', [
            'id' => $queue_section->id,
        ]);
    }

    /** @test */
    public function it_fetch_sections()
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
