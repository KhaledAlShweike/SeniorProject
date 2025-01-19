<?php

use App\Http\Controllers\MedicalRecordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpecialistController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\UserController;
Route::middleware('auth:api')->get('/profile', function (Request $request) {
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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {


});




