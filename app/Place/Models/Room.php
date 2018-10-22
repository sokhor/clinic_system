<?php

namespace App\Place\Models;

use App\Place\Models\Building;
use App\Place\Models\Ward;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $guarded = [];

    /**
     * A room belongs to a ward
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }

    /**
     * A room belongs to a building
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function building()
    {
        return $this->belongsTo(Building::class);
    }
}
