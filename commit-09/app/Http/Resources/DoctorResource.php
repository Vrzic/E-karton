<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
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
            'license_number' => $this->license_number,
            'specialization' => $this->specialization,
            'qualifications' => $this->qualifications,
            'years_of_experience' => $this->years_of_experience,
            'department' => $this->department,
            'is_available' => $this->is_available,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
