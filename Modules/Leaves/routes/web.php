<?php

use Illuminate\Support\Facades\Route;
use Modules\Leaves\Http\Controllers\LeaveController;

Route::middleware(['web','auth'])->prefix('hr')->name('hr.')->group(function () {
    Route::get('leaves', [LeaveController::class,'index'])->name('leaves.index');
    Route::get('employees/{employee}/leaves/create', [LeaveController::class,'create'])->name('leaves.create');
    Route::post('employees/{employee}/leaves', [LeaveController::class,'store'])->name('leaves.store');
    Route::post('leaves/{leave}/approve', [LeaveController::class,'approve'])->name('leaves.approve');
    Route::post('leaves/{leave}/reject', [LeaveController::class,'reject'])->name('leaves.reject');
});
