<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'staffs';

    /**
     * Query doctors
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDoctor(Builder $query)
    {
        return $query->whereExists(function($query) {
            return $query->from('positions')
            ->whereRaw("positions.id = {$this->table}.position_id")
            ->whereRaw("lower(name) = lower('Doctor')");
        });
    }
}
