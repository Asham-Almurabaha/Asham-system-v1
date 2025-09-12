<?php

use Modules\Cars\Http\Controllers\CarController;
use Modules\Cars\Http\Controllers\CarAssignmentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web','auth'])->group(function () {
    Route::resource('cars', CarController::class);
    Route::post('cars/{car}/assignments', [CarAssignmentController::class, 'store'])->name('cars.assignments.store');
    Route::post('cars/{car}/assignments/{assignment}/return', [CarAssignmentController::class, 'return'])->name('cars.assignments.return');
    Route::get('cars/{car}/assignments/history', [CarAssignmentController::class, 'history'])->name('cars.assignments.history');
});
