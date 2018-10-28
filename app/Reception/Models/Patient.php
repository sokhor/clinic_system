<?php

namespace App\Reception\Models;

use App\Reception\Models\Appointment;
use App\Reception\Models\Queue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use SoftDeletes;

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
        'last_visited_at',
        'registered_by',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [ 'dob', 'last_visited_at' ];

    /**
     * Patient may have many appointments over time
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Patient has a queue
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function queues()
    {
        return $this->hasOne(Queue::class);
    }
}
