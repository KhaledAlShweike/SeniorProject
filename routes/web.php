<?php

use App\Http\Controllers\CasesController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\SpecialistController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitController;
use App\Http\Middleware\TenantMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::prefix('ehr')
    ->middleware([TenantMiddleware::class])
    ->group(function () {
        //All EHR routes here ...
        Route::resource('cases', controller: CasesController::class);

        // Add new institution
        Route::post('institutions', [InstitutionController::class, 'addInstitution']);
        // Delete institution
        Route::delete('institutions/{id}', [InstitutionController::class, 'deleteInstitution']);
        // Update institution
        Route::put('institutions/{id}', [InstitutionController::class, 'updateInstitution']);

        // Get all medical records
        Route::get('medical-records', [MedicalRecordController::class, 'index']);
        // Create a new medical record
        Route::post('medical-records', [MedicalRecordController::class, 'store']);
        // Get a specific medical record
        Route::get('medical-records/{id}', [MedicalRecordController::class, 'show']);
        // Update a specific medical record
        Route::put('medical-records/{id}', [MedicalRecordController::class, 'update']);
        // Delete a specific medical record
        Route::delete('medical-records/{id}', [MedicalRecordController::class, 'destroy']);

        // List all patients
        Route::get('patients', [PatientController::class, 'index']);
        // Create a new patient
        Route::post('patients', [PatientController::class, 'store']);
        // Get a specific patient by ID
        Route::get('patients/{id}', [PatientController::class, 'show']);
        // Update a specific patient
        Route::put('patients/{id}', [PatientController::class, 'update']);
        // Delete a specific patient
        Route::delete('patients/{id}', [PatientController::class, 'destroy']);


        // Register a new specialist
        Route::post('specialists', [SpecialistController::class, 'register']);
        // List all specialists
        Route::get('specialists', [SpecialistController::class, 'index']);
        // Update an existing specialist
        Route::put('specialists/{id}', [SpecialistController::class, 'updateSpecialist']);
        // Delete a specialist
        Route::delete('specialists/{id}', [SpecialistController::class, 'deleteSpecialist']);

        // User registration
        Route::post('users/register', [UserController::class, 'register']);
        // User login
        Route::post('users/login', [UserController::class, 'login']);
        // User logout
        Route::post('users/logout', [UserController::class, 'logout']);
        // Refresh JWT token
        Route::post('users/refresh', [UserController::class, 'refresh']);

        // List all visits
        Route::get('visits', [VisitController::class, 'index']);
        // Create a new visit
        Route::post('visits', [VisitController::class, 'store']);
        // Get a specific visit by ID
        Route::get('visits/{id}', [VisitController::class, 'show']);
        // Update a specific visit
        Route::put('visits/{id}', [VisitController::class, 'update']);
        // Delete a specific visit
        Route::delete('visits/{id}', [VisitController::class, 'destroy']);
    });

Route::prefix('mir')
    ->middleware([TenantMiddleware::class])
    ->group(function () {
        // All MIR routes here...

    });
