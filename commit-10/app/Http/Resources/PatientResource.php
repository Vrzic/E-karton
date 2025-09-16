<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
                'date_of_birth' => $this->user->date_of_birth,
                'address' => $this->user->address,
            ],
            'medical_record_number' => $this->medical_record_number,
            'blood_type' => $this->blood_type,
            'allergies' => $this->allergies,
            'medical_history' => $this->medical_history,
            'emergency_contact_name' => $this->emergency_contact_name,
            'emergency_contact_phone' => $this->emergency_contact_name,
            'insurance_provider' => $this->insurance_provider,
            'insurance_number' => $this->insurance_number,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
