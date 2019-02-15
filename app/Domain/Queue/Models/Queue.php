<?php

namespace Domain\Queue\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

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
