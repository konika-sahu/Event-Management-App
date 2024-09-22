<?php

use App\Http\Controllers\Api\AttendeeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout']) ->middleware('auth:sanctum');

// Open routes (no middleware applied)
Route::apiResource('events', EventController::class)->only(['index', 'show']);
// Protected routes (middleware applied)
Route::apiResource('events', EventController::class)->except(['index', 'show'])->middleware('auth:sanctum');

// Public routes (actions that don't require authentication)
Route::apiResource('events.attendees', AttendeeController::class)
    -> scoped() -> except( [ 'update', 'destroy'] ); 

// Authenticated route for 'destroy' action
Route::middleware('auth:sanctum')->group(function () {
    Route::delete('events/{event}/attendees/{attendee}', [AttendeeController::class, 'destroy']);
});