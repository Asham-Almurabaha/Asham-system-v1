<?php

use Illuminate\Support\Facades\Route;
use Modules\Employees\Http\Controllers\EmployeeController;
use Modules\Employees\Http\Controllers\EmployeeResidencyController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('employees', EmployeeController::class);
    Route::prefix('employees/{employee}')->group(function () {
        Route::get('residencies/create', [EmployeeResidencyController::class, 'create'])->name('employees.residencies.create');
        Route::post('residencies', [EmployeeResidencyController::class, 'store'])->name('employees.residencies.store');
    });
});
