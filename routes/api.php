<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('employees', \App\Http\Controllers\Api\EmployeeController::class);

Route::get('verify/{code}', \App\Http\Controllers\Api\EmployeeVerificationController::class);