<?php

namespace App\Place\Models;

use Illuminate\Database\Eloquent\Model;
use App\Place\Models\Ward;

class Building extends Model
{
    protected $fillable = [
        'name_kh',
        'name_en',
        'code',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'deleted' => \App\Place\Events\BuildingDeleted::class,
    ];

    /**
     * Building has many wards
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function wards()
    {
        return $this->belongsToMany(Ward::class);
    }
}
