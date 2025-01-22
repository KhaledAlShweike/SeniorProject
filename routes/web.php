<?php

use App\Http\Middleware\TenantMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::prefix('ehr')
    ->middleware([TenantMiddleware::class])
    ->group(function () {
        //All EHR routes here ...

    });

Route::prefix('mir')
    ->middleware([TenantMiddleware::class])
    ->group(function () {
        // All MIR routes here...

    });
