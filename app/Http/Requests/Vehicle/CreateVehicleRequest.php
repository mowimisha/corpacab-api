<?php

namespace App\Http\Requests\Vehicle;

use Illuminate\Foundation\Http\FormRequest;

class CreateVehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'registration_no' => 'string|min:7',
            'make' => 'string',
            'owner_id' => 'string',
            'driver_id' => 'string',
            'status' => 'string',
            'model' => 'string',
            'yom' => 'string',
            'color' => 'string',
            'fuel_type' => 'string',
            'logbook' => 'image',
            'insurance_sticker' => 'image',
            'uber_inspection' => 'image',
            'vehicle_image' => 'image',
            'psv' => 'image',
            'ntsa_inspection' => 'image'
        ];
    }
}
