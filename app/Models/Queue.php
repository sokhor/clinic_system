<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    /**
     * The fillable attributes on the model.
     *
     * @var array
     */
    protected $fillable = [
        'patient_id',
        'visit_id',
        'token',
        'counter_id',
        'status'
    ];

    /**
     * Take today's queues
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeToday(Builder $query)
    {
        return $query->whereDate('created_at', today());
    }
}
