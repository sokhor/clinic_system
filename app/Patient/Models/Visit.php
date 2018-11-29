<?php

namespace App\Patient\Models;

use App\Patient\Models\Patient;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    /**
     * Set the fillable attributes for the model.
     *
     * @param  array  $fillable
     */
    protected $fillable = [
        'patient_id',
        'consult_operate_by',
        'status',
        'type',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['status_text', 'type_text'];

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

    /**
     * The text equivalance of Type
     *
     * @return string|null
     */
    public function getTypeTextAttribute()
    {
        switch ($this->attributes['status']) {
            case 1:
                return 'OPD';
            case 2:
                return 'IPD';
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
