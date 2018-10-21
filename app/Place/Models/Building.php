<?php

namespace App\Place\Models;

use Illuminate\Database\Eloquent\Model;
use App\Place\Models\Ward;

class Building extends Model
{
    protected $fillable = [
        'name_kh',
        'name_en',
    ];

    public function wards()
    {
        return $this->belongsToMany(Ward::class);
    }
}
