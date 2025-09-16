<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use App\Http\Resources\DoctorResource;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::with(['user', 'healthRecords', 'appointments'])->paginate(10);
        
        return DoctorResource::collection($doctors);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'license_number' => 'required|unique:doctors',
            'specialization' => 'required|string',
            'qualifications' => 'nullable|array',
            'years_of_experience' => 'nullable|string',
            'department' => 'nullable|string',
            'is_available' => 'boolean',
        ]);

        $doctor = Doctor::create($validated);
        
        return new DoctorResource($doctor);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $doctor = Doctor::with(['user', 'healthRecords', 'appointments', 'prescriptions'])->findOrFail($id);
        
        return new DoctorResource($doctor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $doctor = Doctor::findOrFail($id);
        
        $validated = $request->validate([
            'specialization' => 'sometimes|string',
            'qualifications' => 'nullable|array',
            'years_of_experience' => 'nullable|string',
            'department' => 'nullable|string',
            'is_available' => 'boolean',
        ]);

        $doctor->update($validated);
        
        return new DoctorResource($doctor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Doctor deleted successfully'
        ]);
    }

    // Additional methods for higher grades
    public function myPatients()
    {
        $user = Auth::user();
        $doctor = $user->doctor;
        
        if (!$doctor) {
            return response()->json([
                'success' => false,
                'message' => 'Doctor profile not found'
            ], 404);
        }
        
        $patients = $doctor->healthRecords()
            ->with('patient.user')
            ->groupBy('patient_id')
            ->paginate(10);
        
        return response()->json([
            'success' => true,
            'data' => $patients
        ]);
    }

    public function myAppointments()
    {
        $user = Auth::user();
        $doctor = $user->doctor;
        
        if (!$doctor) {
            return response()->json([
                'success' => false,
                'message' => 'Doctor profile not found'
            ], 404);
        }
        
        $appointments = $doctor->appointments()
            ->with('patient.user')
            ->orderBy('appointment_date')
            ->paginate(10);
        
        return response()->json([
            'success' => true,
            'data' => $appointments
        ]);
    }
}
