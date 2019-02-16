<?php

namespace App\Http\Controllers\Queue;

use App\Http\Controllers\Controller;
use App\Http\Resources\QueueResource;
use Domain\Queue\Actions\CreateQueue;
use Domain\Queue\Models\Queue;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    /**
     * Create a new resource
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Queue::class);

        $queue = (new CreateQueue)->execute();

        return new QueueResource($queue);
    }

    /**
     * Get the list of resources
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', Queue::class);

        return QueueResource::collection(Queue::today()->get());
    }
}
