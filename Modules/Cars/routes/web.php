<?php

use Modules\Cars\Http\Controllers\CarController;
use Modules\Cars\Http\Controllers\CarAssignmentController;
use Modules\Cars\Http\Controllers\CarYearController;
use Modules\Cars\Http\Controllers\CarColorController;
use Modules\Cars\Http\Controllers\CarTypeController;
use Modules\Cars\Http\Controllers\CarModelController;
use Modules\Cars\Http\Controllers\CarStatusController;
use Modules\Cars\Http\Controllers\CarBrandController;
use Modules\Cars\Http\Controllers\OilChangeController;
use Modules\Cars\Http\Controllers\CarDocumentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web','auth'])->group(function () {
    Route::resource('cars', CarController::class);
    Route::resource('car-years', CarYearController::class)->except(['show']);
    Route::resource('car-colors', CarColorController::class)->except(['show']);
    Route::resource('car-types', CarTypeController::class)->except(['show']);
    Route::resource('car-brands', CarBrandController::class)->except(['show']);
    Route::resource('car-models', CarModelController::class)->except(['show']);
    Route::resource('car-statuses', CarStatusController::class)->except(['show']);
    
    Route::post('cars/{car}/assignments', [CarAssignmentController::class, 'store'])->name('cars.assignments.store');
    Route::post('cars/{car}/assignments/{assignment}/return', [CarAssignmentController::class, 'return'])->name('cars.assignments.return');
    Route::get('cars/{car}/assignments/history', [CarAssignmentController::class, 'history'])->name('cars.assignments.history');
   
    Route::get('cars/{car}/oil-changes', [OilChangeController::class, 'index'])->name('cars.oil-changes.index');
    Route::post('cars/{car}/oil-changes', [OilChangeController::class, 'store'])->name('cars.oil-changes.store');

    Route::get('cars/{car}/documents', [CarDocumentController::class, 'index'])->name('cars.documents.index');
    Route::post('cars/{car}/documents', [CarDocumentController::class, 'store'])->name('cars.documents.store');
    Route::delete('cars/{car}/documents/{document}', [CarDocumentController::class, 'destroy'])->name('cars.documents.destroy');
});
