<?php

namespace App\Models;

use App\Models\Appointment;
use App\Models\Queue;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Patient extends Model
{
    use SoftDeletes;

    /**
     * The fillable attributes on the model.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'full_name',
        'full_name_2',
        'gender',
        'dob',
        'nationality_code',
        'phone',
        'email',
        'address',
        'identity_type',
        'identity_no',
        'photo',
        'last_visited_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

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
            $model->code = 'PA' . sprintf("%'.03d", $model->id);
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
        return $this->hasMany(Visit::class);
    }

    /**
     * Patient may have a last visit
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lastVisit()
    {
        return $this->hasOne(Visit::class)->latest();
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

        try {
            $birth_date = Carbon::createFromFormat(config('app.date_format'), explode(' ', $this->attributes['dob'])[0]);
        } catch (\Exception $e) {
            $birth_date = Carbon::createFromFormat('Y-m-d', explode(' ', $this->attributes['dob'])[0]);
        }

        return Carbon::today()->diffInYears($birth_date);
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
