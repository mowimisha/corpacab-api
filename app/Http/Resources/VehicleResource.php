<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
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
            'driver_id' => new UserResource(User::where('id', $this->id)->first()),
            'owner_id' => new UserResource(User::where('id', $this->id)->first()),
            'vehicle_image' => (!empty($this->vehicle_image)) ? $this->vehicle_image : null,
            'registration_no' => $this->registration_no,
            'make' => $this->make,
            'model' => $this->model,
            'yom' => $this->yom,
            'color' => $this->color,
            'fuel_type' => $this->fuel_type,
            'status' => $this->status,
            'logbook' => (!empty($this->logbook)) ? $this->logbook : null,
            'insurance_sticker' => (!empty($this->insurance_sticker)) ? $this->insurance_sticker : null,
            'uber_inspection' => (!empty($this->uber_inspection)) ? $this->uber_inspection : null,
            'ntsa_inspection' => (!empty($this->ntsa_inspection)) ? $this->ntsa_inspection : null,
            'psv' => (!empty($this->psv)) ? $this->psv : null,
            'created_at' => Carbon::parse($this->created_at)->format('d-m-Y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d-m-Y'),
        ];
    }
}
