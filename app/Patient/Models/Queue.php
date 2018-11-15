<?php

namespace App\Patient\Models;

use App\Patient\Models\Patient;
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
        'patient_id',
        'queue_no',
        'alive',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'alive' => 'bool',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
