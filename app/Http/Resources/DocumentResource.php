<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
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
            'document_type' => $this->document_type,
            'document_owner' => $this->document_owner,
            'car' => $this->car,
            'issue_date' => Carbon::parse($this->issue_date)->format('d-m-Y'),
            'expiry_date' => Carbon::parse($this->expiry_date)->format('d-m-Y'),
            'reminder_date' => Carbon::parse($this->reminder_date)->format('d-m-Y'),
            'status' => $this->status,
            'created_at' => Carbon::parse($this->created_at)->format('d-m-Y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d-m-Y'),
        ];
    }
}
