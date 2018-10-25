<?php

namespace App\Reception\Models;

use App\Reception\Models\Appointment;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    /**
     * Set the fillable attributes for the model.
     *
     * @param  array  $fillable
     */
    protected $fillable = [
        'code',
        'name_kh',
        'name_en',
        'gender',
        'dob',
        'nationality_code',
        'phone',
        'email',
        'address',
        'identity_type',
        'identity_no',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [ 'dob' ];

    /**
     * Patient may have many appointments over time
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
