<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /**
     * The fillable attributes on the model.
     *
     * @var array
     */
    protected $fillable = [
        'patient_id',
        'subject',
        'appointed_at',
        'comment',
        'doctor_id',
        'status',
    ];
}
