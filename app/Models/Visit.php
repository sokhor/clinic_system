<?php

namespace App\Models;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visit extends Model
{
    use SoftDeletes;

    /**
     * The fillable attributes on the model.
     *
     * @var array
     */
    protected $fillable = [
        'patient_id',
        'assigned_id',
        'type',
        'progress',
        'status',
        'ipd',
        'registered_by',
        'nursing',
        'nursing_by_id',
        'nursing_status',
        'doctor_visit',
        'doctor_visit_by_id',
        'doctor_visit_status',
        'imaging',
        'imaging_by_id',
        'imaging_status',
        'dispensery',
        'dispensery_by_id',
        'dispensery_status',
        'referal_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'ipd' => 'bool',
        'nursing' => 'bool',
        'doctor_visit' => 'bool',
        'imaging' => 'bool',
        'dispensery' => 'bool',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['progress_text'];

    /**
     * The text equivalance of status
     *
     * @return string|null
     */
    public function getProgressTextAttribute()
    {
        switch ($this->attributes['progress']) {
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

    /**
     * Patient visit belongs to a patient
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
