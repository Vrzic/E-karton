<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class AppointmentController extends Controller
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
        $appointments = Appointment::with(['patient.user', 'doctor.user'])->paginate(10);
        
        return response()->json([
            'success' => true,
            'data' => $appointments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after:now',
            'appointment_type' => 'required|in:consultation,follow_up,emergency',
            'reason' => 'nullable|string',
            'status' => 'nullable|in:scheduled,confirmed,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $appointment = Appointment::create($validated);
        
        return response()->json([
            'success' => true,
            'data' => $appointment
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $appointment = Appointment::with(['patient.user', 'doctor.user'])->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $appointment
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $appointment = Appointment::findOrFail($id);
        
        $validated = $request->validate([
            'appointment_date' => 'sometimes|date|after:now',
            'appointment_type' => 'sometimes|in:consultation,follow_up,emergency',
            'reason' => 'nullable|string',
            'status' => 'sometimes|in:scheduled,confirmed,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($validated);
        
        return response()->json([
            'success' => true,
            'data' => $appointment
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Appointment deleted successfully'
        ]);
    }
}
