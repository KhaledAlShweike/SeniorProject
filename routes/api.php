<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Middleware\TenantMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpecialistController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CasesController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\ConditionController;
use App\Http\Controllers\SymptomController;
use App\Http\Controllers\SearchController;



Route::prefix('ehr')
    ->middleware([TenantMiddleware::class])
    ->group(function () {
        //All EHR routes here ...
        Route::resource('cases', controller: CasesController::class);
        Route::get('/patients/{patient_id}/cases', [CasesController::class, 'getCasesByPatientId']);
        Route::get('/specialists/{specialist_id}/patients', [CasesController::class, 'getPatientsBySpecialistId']);
        Route::get('/specialists/{specialist_id}/cases', [CasesController::class, 'getCasesBySpecialistId']);



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
        Route::post('patients', [PatientController::class, 'createPatient']);
        // Get a specific patient by ID
        Route::get('patients/{id}', [PatientController::class, 'show']);
        // Update a specific patient
        Route::put('patients/{id}', [PatientController::class, 'update']);
        // Delete a specific patient
        Route::delete('patients/{id}', [PatientController::class, 'destroy']);


        // Register a new specialist
        Route::post('/specialists/register', [SpecialistController::class, 'registerSpecialist']);
        
        // List all specialists
        Route::get('specialists', [SpecialistController::class, 'index']);
        // Update an existing specialist
        Route::put('specialists/{id}', [SpecialistController::class, 'updateSpecialist']);
        // Delete a specialist
        Route::delete('/specialists/{id}', [SpecialistController::class, 'deleteSpecialists']);

        // User registration
        Route::post('users/register', [UserController::class, 'register']);
        // User login
        Route::post('users/login', [UserController::class, 'login']);
        // User logout

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

        ///////////////////////////
        Route::post('/diagnones', [DiagnosisController::class, 'store']);
        Route::get('getdiag', [DiagnosisController::class, 'index']);
        Route::get('diagnosi/{id}', [DiagnosisController::class, 'show']);
        Route::put('updiagnosi/{id}', [DiagnosisController::class, 'update']);
        Route::delete('deldiagnosi/{id}', [DiagnosisController::class, 'destroy']);


        //////////////////////////
        Route::post('/conditions', [ConditionController::class, 'store']);
        Route::delete('/conditions/{id}', [ConditionController::class, 'destroy']);
        Route::put('/conditions/{id}', [ConditionController::class, 'update']);
        ///////////////////////////
        Route::post('/symptoms', [SymptomController::class, 'store']);
        Route::delete('/symptoms/{id}', [SymptomController::class, 'destroy']);
        Route::put('/symptoms/{id}', [SymptomController::class, 'update']);
        //////////////////////////////////////
        Route::post('/searchh', [SearchController::class, 'search']);
        /////////////////////////////////////////
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('users/logout', [UserController::class, 'logout']);
            Route::delete('/user/{id}', [UserController::class, 'deleteUser']);  // حذف مستخدم
            Route::put('/user/{id}', [UserController::class, 'updateUser']);
        });
        Route::post('/regitster-patien', [PatientController::class, 'registerPatient']);
        Route::post('/specialists/register', [SpecialistController::class, 'registerSpecialist']);
        Route::delete('/specialists/{id}', [SpecialistController::class, 'deleteSpecialists']);
        Route::get('/userss/{id}', [AdminController::class, 'getUserById']);
          /////////////////////////////////////
        

        Route::post('/patients/register', [PatientController::class, 'registerPatientt']);
        Route::get('/userspatient/{id}', [AdminController::class, 'getpatientById']);
        Route::get('/getPatientsWithoutUser', [AdminController::class, 'getPatientsWithoutUser']);  
    });



Route::prefix('mir')
    ->middleware([TenantMiddleware::class])
    ->group(function () {
        // All MIR routes here...

    });


    Route::group([
        'middleware' => 'api',
        'prefix' => 'auth'
    ], function ($router) {
       
    
    });





































/*Route::middleware('auth:api')->get('/profile', function (Request $request) {
    return $request->user();
});

Route::post('/specialist/register', [SpecialistController::class, 'register']);
Route::get('/specialists', [SpecialistController::class, 'index']);
Route::put('/specialistsup/{id}', [SpecialistController::class, 'updateSpecialist']);
Route::delete('/specialistsdel/{id}', [SpecialistController::class, 'deleteSpecialist']);
//////////////////////////////////
Route::post('/institutions/add', [InstitutionController::class, 'addInstitution']);
Route::delete('/institutionsdel/{id}', [InstitutionController::class, 'deleteInstitution']);
Route::put('/institutionsupd/{id}', [InstitutionController::class, 'updateInstitution']);
///////////////////////////////////
Route::post('user/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/auth/logout', [UserController::class, 'logout'])->middleware('auth:api');
///////////////////////////////////////////
Route::get('/getpatient', [PatientController::class, 'index']);
Route::post('/registerpatient', [PatientController::class, 'store']);
Route::get('getpatientt/{id}', [PatientController::class, 'show']);
Route::put('patientup/{id}', [PatientController::class, 'update']);
Route::delete('patientdel/{id}', [PatientController::class, 'destroy']);
///////////////////////////////
Route::apiResource('medical-records', MedicalRecordController::class);
/////////////////////////////////
Route::apiResource('cases', CasesController::class);
/////////////////////////////////
Route::apiResource('visits', VisitController::class);


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {


});*/
