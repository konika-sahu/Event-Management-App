<?php

use App\Http\Controllers\Api\AttendeeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout']) ->middleware('auth:sanctum');

// Open routes (no middleware applied)
Route::apiResource('events', EventController::class)->only(['index', 'show']);
// Protected routes (middleware applied)
Route::apiResource('events', EventController::class)->except(['index', 'show'])->middleware('auth:sanctum');

Route::apiResource('events.attendees', AttendeeController::class)
    -> scoped() -> except( [ 'update' ] );

