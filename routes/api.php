<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FamilyMemberController;
use App\Http\Controllers\Api\MedicalRecordController;
use App\Http\Controllers\Api\ShareController;
use App\Http\Controllers\Api\TimelineController;
use Illuminate\Support\Facades\Route;

// Auth routes (public)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public share access
Route::get('/shared/{token}', [ShareController::class, 'access']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);

    // Family Members
    Route::apiResource('family-members', FamilyMemberController::class);

    // Medical Records
    Route::post('/records/upload', [MedicalRecordController::class, 'upload']);
    Route::get('/records', [MedicalRecordController::class, 'index']);
    Route::get('/records/{id}', [MedicalRecordController::class, 'show']);
    Route::delete('/records/{id}', [MedicalRecordController::class, 'destroy']);

    // Timeline
    Route::get('/timeline', [TimelineController::class, 'index']);

    // Sharing
    Route::post('/share/{record_id}', [ShareController::class, 'create']);
});
