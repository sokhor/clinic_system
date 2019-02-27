<?php

namespace Domain\Queue\Models;

use Domain\Queue\Models\QueueCounter;
use Illuminate\Database\Eloquent\Model;

class QueueSection extends Model
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
        'active' => 'bool',
    ];

    /**
     * It has many counters
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function counters()
    {
        return $this->hasMany(QueueCounter::class, 'section_id');
    }
}
