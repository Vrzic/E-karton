<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Http\Resources\PatientResource;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;

class PatientController extends Controller
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
        $patients = Patient::with(['user', 'healthRecords', 'appointments'])->paginate(10);
        
        return PatientResource::collection($patients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequest $request)
    {
        $patient = Patient::create($request->validated());
        
        return new PatientResource($patient);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $patient = Patient::with(['user', 'healthRecords', 'appointments', 'prescriptions'])->findOrFail($id);
        
        return new PatientResource($patient);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, string $id)
    {
        $patient = Patient::findOrFail($id);
        $patient->update($request->validated());
        
        return new PatientResource($patient);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Patient deleted successfully'
        ]);
    }

    // Additional methods for higher grades
    public function search(Request $request)
    {
        $query = $request->get('q');
        $patients = Patient::whereHas('user', function($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
              ->orWhere('email', 'like', "%{$query}%");
        })->orWhere('medical_record_number', 'like', "%{$query}%")
          ->with('user')
          ->paginate(10);
        
        return PatientResource::collection($patients);
    }

    public function exportCsv()
    {
        $patients = Patient::with('user')->get();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="patients.csv"',
        ];
        
        $callback = function() use ($patients) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Email', 'Medical Record Number', 'Blood Type']);
            
            foreach ($patients as $patient) {
                fputcsv($file, [
                    $patient->id,
                    $patient->user->name,
                    $patient->user->email,
                    $patient->medical_record_number,
                    $patient->blood_type
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    public function profile()
    {
        $user = Auth::user();
        $patient = $user->patient;
        
        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => 'Patient profile not found'
            ], 404);
        }
        
        return new PatientResource($patient);
    }

    public function myAppointments()
    {
        $user = Auth::user();
        $patient = $user->patient;
        
        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => 'Patient profile not found'
            ], 404);
        }
        
        $appointments = $patient->appointments()->with('doctor.user')->paginate(10);
        
        return response()->json([
            'success' => true,
            'data' => $appointments
        ]);
    }

    public function myHealthRecords()
    {
        $user = Auth::user();
        $patient = $user->patient;
        
        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => 'Patient profile not found'
            ], 404);
        }
        
        $healthRecords = $patient->healthRecords()->with('doctor.user')->paginate(10);
        
        return response()->json([
            'success' => true,
            'data' => $healthRecords
        ]);
    }
}
