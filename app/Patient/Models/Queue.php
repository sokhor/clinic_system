<?php

namespace App\Patient\Models;

use App\Patient\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
        'previous_by',
        'next_by',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'alive' => 'bool',
        'previous_by' => 'integer',
        'next_by' => 'integer',
        'status' => 'integer',
    ];

    /**
     * Queue belongs to a patient
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * The text equivalance of status
     *
     * @return string|null
     */
    public function getStatusTextAttribute()
    {
        switch ($this->attributes['status']) {
            case 1:
                return 'Nursing';
            case 2:
                return 'Doctor Visit';
            case 3:
                return 'Lab Test/Imaging';
            case 4:
                return 'Return To Doctor';
            case 5:
                return 'Dispensery';
            case 6:
                return 'Completed';
            default:
                return null;
        }
    }
}
