<?php

use Modules\Motorcycles\Http\Controllers\MotorcycleController;
use Modules\Motorcycles\Http\Controllers\MotorcycleAssignmentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web','auth'])->group(function () {
    Route::resource('motorcycles', MotorcycleController::class);
    Route::post('motorcycles/{motorcycle}/assignments', [MotorcycleAssignmentController::class, 'store'])->name('motorcycles.assignments.store');
    Route::post('motorcycles/{motorcycle}/assignments/{assignment}/return', [MotorcycleAssignmentController::class, 'return'])->name('motorcycles.assignments.return');
    Route::get('motorcycles/{motorcycle}/assignments/history', [MotorcycleAssignmentController::class, 'history'])->name('motorcycles.assignments.history');
});
