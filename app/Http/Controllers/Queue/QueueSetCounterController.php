<?php

namespace App\Http\Controllers\Queue;

use App\Http\Controllers\Controller;
use Domain\Queue\Actions\SetCounter;
use Domain\Queue\Models\Queue;
use Illuminate\Http\Request;

class QueueSetCounterController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Domain\Queue\Models\Queue $queue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Queue $queue)
    {
        $this->authorize('update', Queue::class);

        (new SetCounter)->execute($queue);

        return response()->json(['message' => 'Queue counter was set']);
    }
}
