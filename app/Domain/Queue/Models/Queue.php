<?php

namespace Domain\Queue\Models;

use Domain\Queue\Models\QueueCounter;
use Domain\Queue\Models\QueueSection;
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'section_id' => 'integer',
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

    /**
     * It belongs to a queue section
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section()
    {
        return $this->belongsTo(QueueSection::class);
    }

    /**
     * It belongs to a counter
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function counter()
    {
        return $this->belongsTo(QueueCounter::class);
    }
}
