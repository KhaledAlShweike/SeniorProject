<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('register', [PatientController::class, 'addPatient']);
Route::delete('patientdel/{id}', [PatientController::class, 'deletePatient']);
Route::put('patientup/{id}', [PatientController::class, 'updatePatient']);
///////////////////////////////////////
Route::post('/doctor/register', [DoctorController::class, 'addDoctor']);
Route::delete('/doctor/{id}', [DoctorController::class, 'deleteDoctor']);
Route::put('doctor/{id}', [DoctorController::class, 'updateDoctor']);


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {


});