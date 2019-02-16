<?php

namespace Tests\Unit\Queue;

use Domain\Queue\Actions\CreateQueue;
use Domain\Queue\Models\QueueSection;
use Domain\Queue\ValueObjects\QueueData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QueueTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_generate_a_ticket()
    {
        $queue_section = factory(QueueSection::class)->create(['name' => 'Doctor Consulting']);

        $this->assertEquals('01', (new CreateQueue)->execute(
            QueueData::fromArray(['section_id' => $queue_section->id])
        )->ticket);

        $this->assertEquals('02', (new CreateQueue)->execute(
            QueueData::fromArray(['section_id' => $queue_section->id])
        )->ticket);
    }
}
