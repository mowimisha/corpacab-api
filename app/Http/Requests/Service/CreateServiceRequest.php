<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

class CreateServiceRequest extends FormRequest
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
            'vehicle_registration' => 'required|string|min:7',
            'service_date' => 'date',
            'current_odometer_reading' => 'numeric',
            'kms_serviced' => 'numeric',
            'next_kms_service' => 'numeric',
            'reminder_date' => 'date'
        ];
    }
}
