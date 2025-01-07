<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpecialistController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\UserController;
Route::middleware('auth:api')->get('/profile', function (Request $request) {
    return $request->user();
});

Route::post('/specialist/register', [SpecialistController::class, 'register']);
Route::get('/specialists', [SpecialistController::class, 'index']);
////////////////////////
Route::post('/institutions/add', [InstitutionController::class, 'addInstitution']);
/////////////////////////////////
Route::post('user/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
Route::post('/logout', [UserController::class, 'logout']);

});