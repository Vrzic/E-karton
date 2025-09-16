<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HealthRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'record_type',
        'symptoms',
        'diagnosis',
        'treatment_plan',
        'notes',
        'record_date',
        'status',
    ];

    protected $casts = [
        'record_date' => 'date',
        'symptoms' => 'array',
        'diagnosis' => 'array',
        'treatment_plan' => 'array',
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

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}
