<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
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
            'name' => $this->name,
            'middlename' => $this->middlename,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => 'driver',
            'status' => $this->status,
            'driver_license' => (!empty($this->driver_license)) ? $this->driver_license : null,
            'good_conduct' => (!empty($this->good_conduct)) ? $this->good_conduct : null,
            'profile_picture' => (!empty($this->profile_picture)) ? $this->profile_picture : null,
            'psv' => (!empty($this->psv)) ? $this->psv : null,
            'national_id' => $this->national_id,
            'created_at' => Carbon::parse($this->created_at)->format('d-m-Y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d-m-Y'),
        ];
    }
}
