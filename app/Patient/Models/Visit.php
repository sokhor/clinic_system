<?php

namespace App\Patient\Models;

use App\Patient\Models\Patient;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = [];

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
