<?php

namespace App\Patient\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [ 'next_visit_at' ];
}
