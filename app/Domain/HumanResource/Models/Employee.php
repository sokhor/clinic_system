<?php

namespace Domain\HumanResource\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['born', 'hiring_date'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'address' => 'array',
    ];
}
