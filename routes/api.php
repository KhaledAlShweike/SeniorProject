<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('register', [PatientController::class, 'addPatient']);
Route::delete('patientdel/{id}', [PatientController::class, 'deletePatient']);
Route::put('patientup/{id}', [PatientController::class, 'updatePatient']);




Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {


});