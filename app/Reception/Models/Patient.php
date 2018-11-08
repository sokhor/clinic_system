<?php

namespace App\Reception\Models;

use App\Reception\Models\Appointment;
use App\Reception\Models\Queue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

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
        'referal',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [ 'dob', 'last_visited_at' ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'dob' => 'date:Y-m-d',
    ];

    /**
     * The attributes that should be append.
     *
     * @var array
     */
    protected $appends = ['age', 'identity_type_text'];

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

    /**
     * Mutate age attribute
     *
     * @return int|null
     */
    public function getAgeAttribute()
    {
        if(is_null($this->attributes['dob'])) {
            return null;
        }

        return Carbon::today()->diffInYears(Carbon::createFromFormat('Y-m-d', explode(' ',$this->attributes['dob'])[0]));
    }

    /**
     * Mutate identity type into text
     *
     * @return string|null
     */
    public function getIdentityTypeTextAttribute()
    {
        switch ($this->attributes['identity_type']) {
            case 1:
                return 'National ID';
            case 2:
                return 'Passport';
            case 3:
                return 'Driving License';
            default:
                return null;
        }
    }
}
