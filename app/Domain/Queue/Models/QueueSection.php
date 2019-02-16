<?php

namespace Domain\Queue\Models;

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
}
