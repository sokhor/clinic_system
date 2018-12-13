<?php

namespace App\Patient\Models;

use App\Patient\Models\Medication;
use App\Patient\Models\Patient;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * It belongs to a patient.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * It has many medications
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function medications()
    {
        return $this->hasMany(Medication::class);
    }
}
