<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Repositories\QueueRepository;
use Illuminate\Http\Request;

class QueueCounterController extends Controller
{
    /**
     * Queue repository
     *
     * @var \App\Repositories\QueueRepository
     */
    protected $queue;

    /**
     * Create the controller instance
     *
     * @param \App\Repositories\QueueRepository $queue
     */
    public function __construct(QueueRepository $queue)
    {
        $this->queue = $queue;
    }

    public function update(Request $request, Queue $queue)
    {
        $this->queue->setCounter($queue);

        return response()->json(['message' => 'Queue\'s counter was set']);
    }
}
