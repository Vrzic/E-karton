<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\HealthRecord;

class ReportsController extends Controller
{
    public function summary()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'total_patients' => Patient::count(),
                'total_doctors' => Doctor::count(),
                'total_appointments' => Appointment::count(),
                'total_health_records' => HealthRecord::count(),
            ]
        ]);
    }
}


