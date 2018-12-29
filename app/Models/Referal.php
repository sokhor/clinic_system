<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referal extends Model
{
    /**
     * The fillable attributes on the model.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'phone',
        'email',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
