<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    /**
     * The fillable attributes on the model.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'order',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
