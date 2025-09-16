<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nurse extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'license_number',
        'department',
        'qualifications',
        'years_of_experience',
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
}
