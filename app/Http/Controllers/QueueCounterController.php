<?php

namespace App\Http\Controllers;

use Domain\Queue\Actions\SetCounter;
use Domain\Queue\Models\Queue;
use Illuminate\Http\Request;

class QueueCounterController extends Controller
{
    public function update(Request $request, Queue $queue)
    {
        $this->authorize('update', Queue::class);

        (new SetCounter($queue))->execute();

        return response()->json(['message' => 'Queue\'s counter was set']);
    }
}
