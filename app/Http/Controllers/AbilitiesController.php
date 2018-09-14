<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Bouncer;

class AbilitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Bouncer::ability()
            ->where('name', '<>', '*')->get()
            ->map(function($ability) {
                return collect($ability)->merge([
                    'module' => ucfirst(last(explode('-', $ability->name)))
                ]);
            });
    }
}
