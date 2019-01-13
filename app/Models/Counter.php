<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    /**
     * The fillable attributes on the model.
     *
     * @var array
     */
    protected $fillable = [
        'label',
        'disabled',
        'available',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'disabled' => 'boolean',
        'available' => 'boolean',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function scopeAvailable(Builder $query)
    {
        return $query->where('available', true)
            ->where('disabled', false);
    }
}