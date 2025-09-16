<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'health_record_id',
        'medications',
        'dosage_instructions',
        'prescribed_date',
        'valid_until',
        'status',
        'notes',
    ];

    protected $casts = [
        'prescribed_date' => 'date',
        'valid_until' => 'date',
        'medications' => 'array',
        'dosage_instructions' => 'array',
    ];

    // Relationships
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function healthRecord()
    {
        return $this->belongsTo(HealthRecord::class);
    }
}
