<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'vehicle_registration', 'service_date', 'current_odometer_reading', 'kms_serviced', 'next_kms_service', 'reminder_date',
        'status', 'battery_status',
    ];

    public function vehicle()
    {
        return $this->belongsTo('App\Models\Vehicle');
    }
}
