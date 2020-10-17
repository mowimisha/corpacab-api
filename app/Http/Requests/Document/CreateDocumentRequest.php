<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

class CreateDocumentRequest extends FormRequest
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
            'document_type' => 'required',
            'document_owner' => 'required',
            'issue_date' => 'required',
            'expiry_date' => 'required',
            'reminder_date' => 'required',
        ];
    }
}
