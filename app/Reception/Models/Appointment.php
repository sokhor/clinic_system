<?php

namespace App\Reception\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /**
     * Set the fillable attributes for the model.
     *
     * @param  array  $fillable
     */
    protected $fillable = [
        'patient_id',
        'next_visit_at',
        'referal',
        'refer_to',
        'type',
        'status',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [ 'next_visit_at' ];
}
