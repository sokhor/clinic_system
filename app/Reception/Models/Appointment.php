<?php

namespace App\Reception\Models;

use App\Reception\Models\Queue;
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
        'visit_at',
        'referal',
        'refer_to',
        'type',
        'status',
        'created_by',
        'modified_by',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [ 'visit_at' ];

    /**
     * Appoint has one queue
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function queue()
    {
        return $this->hasOne(Queue::class);
    }
}
