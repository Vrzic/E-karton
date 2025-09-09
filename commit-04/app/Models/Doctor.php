<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'license_number',
        'specialization',
        'qualifications',
        'years_of_experience',
        'department',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'qualifications' => 'array',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function healthRecords()
    {
        return $this->hasMany(HealthRecord::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}
