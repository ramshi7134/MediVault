<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\FamilyMemberController;
use App\Http\Controllers\Web\MedicalRecordController;
use App\Http\Controllers\Web\TimelineController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Guest-only auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Medical Records
    Route::get('/records', [MedicalRecordController::class, 'index'])->name('records.index');
    Route::get('/records/create', [MedicalRecordController::class, 'create'])->name('records.create');
    Route::post('/records', [MedicalRecordController::class, 'store'])->name('records.store');
    Route::get('/records/{id}', [MedicalRecordController::class, 'show'])->name('records.show');
    Route::delete('/records/{id}', [MedicalRecordController::class, 'destroy'])->name('records.destroy');
    Route::post('/records/{id}/share', [MedicalRecordController::class, 'share'])->name('records.share');

    // Family Members
    Route::get('/family', [FamilyMemberController::class, 'index'])->name('family.index');
    Route::get('/family/create', [FamilyMemberController::class, 'create'])->name('family.create');
    Route::post('/family', [FamilyMemberController::class, 'store'])->name('family.store');
    Route::get('/family/{id}/edit', [FamilyMemberController::class, 'edit'])->name('family.edit');
    Route::put('/family/{id}', [FamilyMemberController::class, 'update'])->name('family.update');
    Route::delete('/family/{id}', [FamilyMemberController::class, 'destroy'])->name('family.destroy');

    // Timeline
    Route::get('/timeline', [TimelineController::class, 'index'])->name('timeline');
});
