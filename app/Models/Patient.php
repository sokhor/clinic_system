<?php

namespace App\Models;

use App\Patient\Models\Appointment;
use App\Patient\Models\Queue;
use App\Patient\Models\Visit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Patient extends Model
{
    use SoftDeletes;

    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = [];

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
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function($model) {
            $model->code = 'PA' . $model->id;
            $model->save();
        });
    }

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
     * Patient may have many visits
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visits()
    {
        return $this->hasMany(Visit::class)->latest();
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

        return Carbon::today()->diffInYears(
            Carbon::createFromFormat('Y-m-d', explode(' ',$this->attributes['dob'])[0])
        );
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
