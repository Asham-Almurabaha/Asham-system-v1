<?php

use Illuminate\Support\Facades\Route;
use Modules\Employees\Http\Controllers\EmployeeController;
use Modules\Employees\Http\Controllers\EmployeeResidencyController;
use Modules\Employees\Http\Controllers\WorkStatusController;
use Modules\Employees\Http\Controllers\ResidencyStatusController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('work-statuses', WorkStatusController::class);
    Route::resource('residency-statuses', ResidencyStatusController::class);
    Route::resource('employees', EmployeeController::class);
    Route::prefix('employees/{employee}')->group(function () {
        Route::get('residencies/create', [EmployeeResidencyController::class, 'create'])->name('employees.residencies.create');
        Route::post('residencies', [EmployeeResidencyController::class, 'store'])->name('employees.residencies.store');
    });
});
