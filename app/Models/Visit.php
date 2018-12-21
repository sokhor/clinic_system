<?php

namespace App\Models;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visit extends Model
{
    use SoftDeletes;

    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = [];

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
