<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{

    protected $guarded = [];


    protected $fillable = [
        'registration_no', 'make', 'owner_id', 'driver_id', 'status', 'model', 'yom', 'color', 'fuel_type', 'logbook', 'insurance_sticker',
        'uber_inspection', 'vehicle_image', 'psv', 'ntsa_inspection'
    ];

    public function user()
    {
        return $this->hasMany('App\Models\User');
    }

    public function service()
    {
        return $this->hasMany('App\Models\Service');
    }

    public function document()
    {
        return $this->hasMany('App\Models\Document');
    }

    public function expense()
    {
        return $this->hasMany('App\Models\Expense');
    }
}
