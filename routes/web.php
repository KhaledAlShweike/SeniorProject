<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CasesController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\SpecialistController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\ConditionController;
use App\Http\Controllers\SymptomController;
use App\Http\Middleware\TenantMiddleware;

// Welcome Route
Route::get('/', function () {
    return view('welcome');
});

// EHR (Electronic Health Records) Routes
Route::prefix('ehr')->middleware([TenantMiddleware::class])->group(function () {

    // Cases Routes
    Route::apiResource('cases', CasesController::class);
    Route::get('patients/{patient_id}/cases', [CasesController::class, 'getCasesByPatientId']);
    Route::get('specialists/{specialist_id}/patients', [CasesController::class, 'getPatientsBySpecialistId']);
    Route::get('specialists/{specialist_id}/cases', [CasesController::class, 'getCasesBySpecialistId']);

    // Institution Routes
    Route::apiResource('institutions', InstitutionController::class);

    // Medical Record Routes
    Route::apiResource('medical-records', MedicalRecordController::class);

    // Patient Routes
    Route::apiResource('patients', PatientController::class);

    // Specialist Routes
    Route::apiResource('specialists', SpecialistController::class);

    // User Authentication Routes
    Route::prefix('users')->group(function () {
        Route::post('register', [UserController::class, 'register']);
        Route::post('login', [UserController::class, 'login']);
    });

    // Visit Routes
    Route::apiResource('visits', VisitController::class);

    // Diagnosis Routes
    Route::apiResource('diagnosis', DiagnosisController::class);

    // Condition Routes
    Route::apiResource('conditions', ConditionController::class)->only(['store', 'update', 'destroy']);

    // Symptom Routes
    Route::apiResource('symptoms', SymptomController::class)->only(['store', 'update', 'destroy']);

    // Admin Routes
    Route::post('/admin/login', [AdminController::class, 'login']);

    // Sanctum-Protected Admin Routes
    Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
        Route::get('/specialists/pending', [AdminController::class, 'getPendingSpecialists']);
        Route::put('/specialists/{id}/approve', [AdminController::class, 'updateSpecialistStatus']);

        // Admin can also manage institutions
        Route::apiResource('institutions', InstitutionController::class)->only(['index', 'store', 'update', 'destroy']);
    });
});

// MIR (Multimodal Information Retrieval) Routes
Route::prefix('mir')->middleware([TenantMiddleware::class])->group(function () {
    // Define MIR-specific routes here...
});

// Sanctum Authentication Routes
Route::middleware('auth:sanctum')->prefix('auth')->group(function () {
    Route::post('logout', [UserController::class, 'logout']);
    Route::post('refresh', [UserController::class, 'refresh']);
});
