<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AppointmentApiController;

Route::apiResource('appointments', AppointmentApiController::class)
    ->names('api.appointments');
