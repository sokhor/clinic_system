<?php

namespace App\Patient\Models;

use App\Patient\Models\MedicalRecord;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * It belongs to a medical record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function medical_record()
    {
        return $this->belongsTo(MedicalRecord::class);
    }
}
