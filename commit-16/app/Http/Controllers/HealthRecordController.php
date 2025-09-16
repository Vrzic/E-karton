<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HealthRecord;
use App\Http\Resources\HealthRecordResource;

class HealthRecordController extends Controller
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
        $healthRecords = HealthRecord::with(['patient.user', 'doctor.user'])->paginate(10);
        
        return HealthRecordResource::collection($healthRecords);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'record_type' => 'required|in:consultation,examination,treatment',
            'symptoms' => 'nullable|array',
            'diagnosis' => 'nullable|array',
            'treatment_plan' => 'nullable|array',
            'notes' => 'nullable|string',
            'record_date' => 'required|date',
            'status' => 'nullable|in:active,archived,deleted',
        ]);

        $healthRecord = HealthRecord::create($validated);
        
        return new HealthRecordResource($healthRecord);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $healthRecord = HealthRecord::with(['patient.user', 'doctor.user', 'prescriptions'])->findOrFail($id);
        
        return new HealthRecordResource($healthRecord);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $healthRecord = HealthRecord::findOrFail($id);
        
        $validated = $request->validate([
            'record_type' => 'sometimes|in:consultation,examination,treatment',
            'symptoms' => 'nullable|array',
            'diagnosis' => 'nullable|array',
            'treatment_plan' => 'nullable|array',
            'notes' => 'nullable|string',
            'record_date' => 'sometimes|date',
            'status' => 'sometimes|in:active,archived,deleted',
        ]);

        $healthRecord->update($validated);
        
        return new HealthRecordResource($healthRecord);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $healthRecord = HealthRecord::findOrFail($id);
        $healthRecord->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Health record deleted successfully'
        ]);
    }

    // Additional methods for higher grades
    public function nurseView()
    {
        $user = Auth::user();
        $nurse = $user->nurse;
        
        if (!$nurse) {
            return response()->json([
                'success' => false,
                'message' => 'Nurse profile not found'
            ], 404);
        }
        
        $healthRecords = HealthRecord::with(['patient.user', 'doctor.user'])
            ->where('status', 'active')
            ->paginate(10);
        
        return response()->json([
            'success' => true,
            'data' => $healthRecords
        ]);
    }
}
