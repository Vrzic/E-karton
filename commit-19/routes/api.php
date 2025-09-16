<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HealthRecordController;
use App\Http\Controllers\AppointmentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Patient routes
    Route::apiResource('patients', PatientController::class);
    
    // Doctor routes
    Route::apiResource('doctors', DoctorController::class);
    
    // Health record routes
    Route::apiResource('health-records', HealthRecordController::class);
    
    // Appointment routes
    Route::apiResource('appointments', AppointmentController::class);
    
    // Additional routes for higher grades
    Route::get('/patients/search', [PatientController::class, 'search']);
    Route::get('/patients/export/csv', [PatientController::class, 'exportCsv']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

// Minimal OpenAPI stub for documentation discovery
Route::get('/openapi.json', function () {
    return response()->json([
        'openapi' => '3.0.0',
        'info' => [
            'title' => 'Health Records API',
            'version' => '1.0.0',
        ],
        'paths' => new \stdClass(),
    ]);
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    // Admin only routes
    Route::get('/admin/stats', [AuthController::class, 'adminStats']);
    Route::delete('/admin/users/{user}', [AuthController::class, 'deleteUser']);
});

Route::middleware(['auth:sanctum', 'role:doctor'])->group(function () {
    // Doctor only routes
    Route::get('/doctor/patients', [DoctorController::class, 'myPatients']);
    Route::get('/doctor/appointments', [DoctorController::class, 'myAppointments']);
});

Route::middleware(['auth:sanctum', 'role:nurse'])->group(function () {
    // Nurse only routes
    Route::get('/nurse/patients', [HealthRecordController::class, 'nurseView']);
});

Route::middleware(['auth:sanctum', 'role:patient'])->group(function () {
    // Patient only routes
    Route::get('/patient/profile', [PatientController::class, 'profile']);
    Route::get('/patient/appointments', [PatientController::class, 'myAppointments']);
    Route::get('/patient/health-records', [PatientController::class, 'myHealthRecords']);
});



