<?php

namespace App\Reception\Models;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    /**
     * Set the fillable attributes for the model.
     *
     * @param  array  $fillable
     * @return $this
     */
    protected $fillable = [
        'appointment_id',
        'queue_no',
        'alive',
    ];
}
