<?php

namespace App\Repositories;

use App\Models\Visit;
use App\Models\Queue;

class VisitRepository
{
    /**
     * Create a new visit
     *
     * @param  Array $params
     * @return \App\Models\Visit
     */
    public function create($params)
    {
        $visit = Visit::create(array_merge($params, [
            'progress' => isset($params['progress']) ? $params['progress'] : 1,
            'referal_id' => isset($params['referal_id']) ? $params['referal_id'] : null,
            'registered_by' => auth()->id()
        ]));

        return $visit;
    }
}
