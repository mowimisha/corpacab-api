<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'vehicle_registration' => $this->vehicle_registration,
            'service_date' => Carbon::parse($this->service_date)->format('d-m-Y'),
            'current_odometer_reading' => $this->current_odometer_reading,
            'kms_serviced' => $this->kms_serviced,
            'next_kms_service' => $this->next_kms_service,
            'reminder_date' => Carbon::parse($this->reminder_date)->format('d-m-Y'),
            'status' => $this->status,
            'battery_status' => $this->battery_status,
            'created_at' => Carbon::parse($this->created_at)->format('d-m-Y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d-m-Y'),
        ];
    }
}
