<?php

namespace Tests\Feature;

use App\Patient\Models\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class QueueTest extends TestCase
{
    use RefreshDatabase;

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
                    'id',
                    'patient_id',
                    'patient',
                    'queue_no',
                    'previous_by',
                    'next_by',
                    'status',
                    'status_text',
                ],
            ],
        ]);

        // Assert should show only today queues.
        $data = json_decode($response->getContent())->data;
        $this->assertCount(1, $data);
        $this->assertEquals($queue_2->id, $data[0]->id);
    }
}
