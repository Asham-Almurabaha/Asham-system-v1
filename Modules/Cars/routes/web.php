<?php

use Modules\Cars\Http\Controllers\CarController;
use Modules\Cars\Http\Controllers\CarAssignmentController;
use Modules\Cars\Http\Controllers\CarYearController;
use Modules\Cars\Http\Controllers\CarColorController;
use Modules\Cars\Http\Controllers\CarTypeController;
use Modules\Cars\Http\Controllers\CarModelController;
use Modules\Cars\Http\Controllers\CarStatusController;
use Modules\Cars\Http\Controllers\CarBrandController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web','auth'])->group(function () {
    Route::resource('cars', CarController::class);
    Route::resource('car-years', CarYearController::class)->only(['index','store','update','destroy']);
    Route::resource('car-colors', CarColorController::class)->only(['index','store','update','destroy']);
    Route::resource('car-types', CarTypeController::class)->only(['index','store','update','destroy']);
    Route::resource('car-brands', CarBrandController::class)->only(['index','store','update','destroy']);
    Route::resource('car-models', CarModelController::class)->only(['index','store','update','destroy']);
    Route::resource('car-statuses', CarStatusController::class)->only(['index','store','update','destroy']);
    Route::post('cars/{car}/assignments', [CarAssignmentController::class, 'store'])->name('cars.assignments.store');
    Route::post('cars/{car}/assignments/{assignment}/return', [CarAssignmentController::class, 'return'])->name('cars.assignments.return');
    Route::get('cars/{car}/assignments/history', [CarAssignmentController::class, 'history'])->name('cars.assignments.history');
});
